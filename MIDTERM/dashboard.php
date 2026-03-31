<?php
// ====================== PHẦN PHP XỬ LÝ CRUD ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=computer_management;charset=utf8mb4", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Kết nối DB lỗi: ' . $e->getMessage()]);
        exit;
    }

    $action = $_POST['action'] ?? '';

    switch ($action) {
        // READ + SEARCH
        case 'read':
            $search = '%' . ($_POST['search'] ?? '') . '%';
            $stmt = $pdo->prepare("SELECT * FROM computers WHERE computer_name LIKE ? ORDER BY id DESC");
            $stmt->execute([$search]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $data, 'total' => count($data)]);
            break;

        // CREATE
        case 'create':
            $name = trim($_POST['computer_name'] ?? '');
            $model = trim($_POST['model'] ?? '');
            if (empty($name) || empty($model)) {
                echo json_encode(['success' => false, 'message' => 'Tên máy và Model là bắt buộc!']);
                exit;
            }
            $stmt = $pdo->prepare("INSERT INTO computers (computer_name, model, operating_system, processor, memory, available) 
                                  VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $name, $model, 
                $_POST['operating_system'] ?? null,
                $_POST['processor'] ?? null,
                (int)($_POST['memory'] ?? 16),
                (int)($_POST['available'] ?? 1)
            ]);
            echo json_encode(['success' => true, 'message' => '✅ Thêm máy tính thành công!']);
            break;

        // UPDATE
        case 'update':
            $id = (int)$_POST['id'];
            $name = trim($_POST['computer_name'] ?? '');
            $model = trim($_POST['model'] ?? '');
            if ($id <= 0 || empty($name) || empty($model)) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ!']);
                exit;
            }
            $stmt = $pdo->prepare("UPDATE computers SET computer_name=?, model=?, operating_system=?, processor=?, memory=?, available=? WHERE id=?");
            $stmt->execute([
                $name, $model,
                $_POST['operating_system'] ?? null,
                $_POST['processor'] ?? null,
                (int)($_POST['memory'] ?? 16),
                (int)($_POST['available'] ?? 1),
                $id
            ]);
            echo json_encode(['success' => true, 'message' => '✅ Cập nhật thành công!']);
            break;

        // DELETE
        case 'delete':
            $id = (int)$_POST['id'];
            if ($id <= 0) exit;
            // Xóa luôn issues liên quan
            $pdo->prepare("DELETE FROM issues WHERE computer_id = ?")->execute([$id]);
            $pdo->prepare("DELETE FROM computers WHERE id = ?")->execute([$id]);
            echo json_encode(['success' => true, 'message' => '🗑️ Xóa máy tính thành công!']);
            break;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Lab Management System</title>
    <style>
        /* CSS đẹp như trong file tôi đưa trước */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');
        :root { --primary: #0066cc; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',sans-serif; background:linear-gradient(135deg,#f5f7fa,#c3cfe2); min-height:100vh; padding:20px; }
        .container { max-width:1400px; margin:0 auto; background:white; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.1); overflow:hidden; }
        header { background:var(--primary); color:white; padding:20px 30px; display:flex; justify-content:space-between; align-items:center; }
        h1 { font-size:24px; }
        .search-box { display:flex; background:rgba(255,255,255,0.2); border-radius:30px; padding:8px 15px; width:320px; }
        .search-box input { background:none; border:none; outline:none; color:white; width:100%; margin-left:10px; }
        .btn { padding:10px 20px; border:none; border-radius:8px; cursor:pointer; font-weight:600; }
        .btn-primary { background:white; color:var(--primary); }
        .modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:1000; align-items:center; justify-content:center; }
        .modal-content { background:white; width:100%; max-width:520px; border-radius:16px; }
        table { width:100%; border-collapse:collapse; }
        th, td { padding:14px 12px; text-align:left; border-bottom:1px solid #eee; }
        th { background:#f8f9fa; }
        .status { padding:4px 12px; border-radius:20px; font-size:13px; }
        .status-available { background:#d4edda; color:#155724; }
        .status-repair { background:#f8d7da; color:#721c24; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div>
                <h1>🖥️ Computer Lab Management</h1>
                <p>University IT Department</p>
            </div>
            <div style="display:flex; gap:15px; align-items:center;">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Tìm theo tên máy..." onkeyup="filterTable()">
                </div>
                <button onclick="showAddModal()" class="btn btn-primary">+ Thêm Máy Mới</button>
            </div>
        </header>

        <div style="padding:30px;">
            <h2>Danh sách máy tính (<span id="recordCount">0</span>)</h2>
            <div style="overflow-x:auto;">
                <table id="computersTable">
                    <thead>
                        <tr>
                            <th>ID</th><th>Tên máy</th><th>Model</th><th>HĐH</th><th>CPU</th><th>RAM</th><th>Trạng thái</th><th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Add/Edit -->
    <div id="computerModal" class="modal">
        <div class="modal-content">
            <div style="padding:20px 25px; border-bottom:1px solid #eee; display:flex; justify-content:space-between;">
                <h3 id="modalTitle">Thêm Máy Tính Mới</h3>
                <button onclick="hideModal()" style="font-size:28px; background:none; border:none; cursor:pointer;">×</button>
            </div>
            <form id="computerForm" onsubmit="handleFormSubmit(event)" style="padding:25px;">
                <input type="hidden" id="editId">
                <div style="margin-bottom:15px;">
                    <label>Tên máy <span style="color:red;">*</span></label>
                    <input type="text" id="computer_name" required>
                </div>
                <div style="margin-bottom:15px;">
                    <label>Model <span style="color:red;">*</span></label>
                    <input type="text" id="model" required>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                    <div>
                        <label>Hệ điều hành</label>
                        <input type="text" id="operating_system">
                    </div>
                    <div>
                        <label>Processor</label>
                        <input type="text" id="processor">
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-top:15px;">
                    <div>
                        <label>RAM (GB)</label>
                        <input type="number" id="memory" value="16">
                    </div>
                    <div>
                        <label>Trạng thái</label>
                        <select id="available">
                            <option value="1">✅ Available</option>
                            <option value="0">🔧 Under Repair</option>
                        </select>
                    </div>
                </div>
                <div style="margin-top:25px; text-align:right;">
                    <button type="button" onclick="hideModal()" style="padding:10px 20px; background:#e9ecef; border:none; border-radius:8px; margin-right:10px;">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let computersData = [];
        async function fetchComputers(search = '') {
            const form = new FormData();
            form.append('action', 'read');
            if (search) form.append('search', search);
            
            const res = await fetch('dashboard.php', { method: 'POST', body: form });
            const json = await res.json();
            if (json.success) {
                computersData = json.data;
                renderTable(computersData);
            }
        }

        function renderTable(data) {
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';
            data.forEach(c => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>#${c.id}</td>
                    <td><strong>${c.computer_name}</strong></td>
                    <td>${c.model}</td>
                    <td>${c.operating_system || '—'}</td>
                    <td>${c.processor || '—'}</td>
                    <td>${c.memory} GB</td>
                    <td>${c.available == 1 ? '<span class="status status-available">✅ Available</span>' : '<span class="status status-repair">🔧 Repair</span>'}</td>
                    <td>
                        <button onclick="editComputer(${c.id})" style="background:#007bff;color:white;border:none;padding:6px 12px;border-radius:6px;">✏️</button>
                        <button onclick="deleteComputer(${c.id}, '${c.computer_name}')" style="background:#dc3545;color:white;border:none;padding:6px 12px;border-radius:6px;">🗑️</button>
                    </td>`;
                tbody.appendChild(row);
            });
            document.getElementById('recordCount').textContent = data.length;
        }

        function filterTable() {
            const term = document.getElementById('searchInput').value.toLowerCase();
            const filtered = computersData.filter(c => c.computer_name.toLowerCase().includes(term));
            renderTable(filtered);
        }

        function showAddModal() {
            document.getElementById('modalTitle').innerText = 'Thêm Máy Tính Mới';
            document.getElementById('computerForm').reset();
            document.getElementById('editId').value = '';
            document.getElementById('computerModal').style.display = 'flex';
        }

        function editComputer(id) {
            const comp = computersData.find(c => c.id === id);
            if (!comp) return;
            document.getElementById('modalTitle').innerText = 'Sửa Máy #' + id;
            document.getElementById('editId').value = comp.id;
            document.getElementById('computer_name').value = comp.computer_name;
            document.getElementById('model').value = comp.model;
            document.getElementById('operating_system').value = comp.operating_system || '';
            document.getElementById('processor').value = comp.processor || '';
            document.getElementById('memory').value = comp.memory;
            document.getElementById('available').value = comp.available;
            document.getElementById('computerModal').style.display = 'flex';
        }

        function hideModal() {
            document.getElementById('computerModal').style.display = 'none';
        }

        async function handleFormSubmit(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            formData.append('action', document.getElementById('editId').value ? 'update' : 'create');
            
            const res = await fetch('dashboard.php', { method: 'POST', body: formData });
            const json = await res.json();
            
            if (json.success) {
                hideModal();
                alert(json.message);
                fetchComputers(document.getElementById('searchInput').value);
            } else {
                alert(json.message);
            }
        }

        async function deleteComputer(id, name) {
            if (!confirm(`Xóa máy "${name}" (#${id})?`)) return;
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);
            const res = await fetch('dashboard.php', { method: 'POST', body: formData });
            const json = await res.json();
            if (json.success) {
                alert(json.message);
                fetchComputers(document.getElementById('searchInput').value);
            }
        }

        window.onload = () => fetchComputers();
    </script>
</body>
</html>
