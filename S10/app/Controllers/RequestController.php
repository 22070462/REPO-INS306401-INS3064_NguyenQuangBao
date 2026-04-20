<?php

class RequestController
{
    public function index()
    {
        echo "Request list";
    }

    public function show($id)
    {
        echo "Show request " . $id;
    }

    public function updateStatus($id)
    {
        echo "Update status";
    }
}
