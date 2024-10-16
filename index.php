<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.3.1/dist/jsQR.js"></script>
    <title>Employee ID Card</title>
    <style>
        /* Basic styling for the page */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        #employee-details {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    margin-left: 37px;
    border: 2px solid;
    border-radius: 50px;
}
    </style>
</head>
<body>

    <h1>Scan Employee QR Code</h1>
    <button id="open-camera">Open Camera</button>
    <video id="camera-preview" width="300" height="200" style="display:none;"></video>
    <div id="employee-details">
        <img id="emp-photo" src="" alt="Employee Photo">
        <h3 id="emp-name"></h3>
        <p id="emp-email"></p> 
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsQR/1.4.0/jsQR.min.js"></script>
    <script>
        const cameraButton = document.getElementById('open-camera');
        const video = document.getElementById('camera-preview');
        const employeeDetails = document.getElementById('employee-details');
        const empPhoto = document.getElementById('emp-photo');
        const empName = document.getElementById('emp-name');
        const empEmail = document.getElementById('emp-email');

        cameraButton.addEventListener('click', async () => {
    // Open the camera
    video.style.display = 'block';
    const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
    video.srcObject = stream;
    video.play();
    
    const scanQRCode = () => {
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');

        // Make sure the video is loaded and has width/height
        if (video.videoWidth === 0 || video.videoHeight === 0) {
            requestAnimationFrame(scanQRCode);  // Wait until the video is fully loaded
            return;
        }

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, canvas.width, canvas.height);

        let employees = [
            { id: '30115075635', name: 'Karam Mohammad', email: 'karammohd@gmail.com', photo: 'images/pic.jpg' },
            { id: '31183377041', name: 'Shailesh K', email: 'Shailesh@unidesign.com', photo: 'images/pic2.png' },
        ];

        if (code) {
            // Stop the camera when a QR code is detected
            video.srcObject.getTracks().forEach(track => track.stop());
            video.style.display = 'none';
            
            // Process the detected QR code
            const employee = employees.find(emp => emp.id === code.data); // Use find method
            if (employee) {
                empPhoto.src = employee.photo;
                empName.textContent = employee.name;
                empEmail.textContent = employee.email;
                employeeDetails.style.display = 'block';
            } else {
                alert('Employee not found!');
            }
        } else {
            requestAnimationFrame(scanQRCode);  // Continue scanning
        }
    };

    scanQRCode();
});

    </script>
</body>
</html>
