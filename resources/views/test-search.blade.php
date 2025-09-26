<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Search</title>
</head>
<body>
    <h1>Test Search Functionality</h1>
    
    <form id="testForm">
        @csrf
        <div>
            <label for="ic_number">IC Number:</label>
            <input type="text" id="ic_number" name="ic_number" value="123456789012" required>
        </div>
        
        <div>
            <label for="search_type">Search Type:</label>
            <select id="search_type" name="search_type" required>
                <option value="bankruptcy">Bankruptcy</option>
                <option value="annulment">Annulment</option>
            </select>
        </div>
        
        <button type="submit">Test Search</button>
    </form>
    
    <div id="results"></div>
    
    <script>
    document.getElementById('testForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        console.log('Form data:', {
            ic_number: formData.get('ic_number'),
            search_type: formData.get('search_type'),
            _token: formData.get('_token')
        });
        
        fetch('/test-search-api', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            document.getElementById('results').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('results').innerHTML = '<p style="color: red;">Error: ' + error.message + '</p>';
        });
    });
    </script>
</body>
</html>
