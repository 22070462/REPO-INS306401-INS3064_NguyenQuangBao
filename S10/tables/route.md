# Route Table

| HTTP | URL | Controller@Action | Purpose |
|------|----|------------------|---------|
| GET | /requests | RequestController@index | List requests |
| GET | /requests/create | RequestController@create | Show form |
| POST | /requests | RequestController@store | Save request |
| GET | /requests/{id} | RequestController@show | Show details |
| POST | /requests/{id}/status | RequestController@updateStatus | Update status |
| GET | /staff/requests | RequestController@staffIndex | Staff view |
