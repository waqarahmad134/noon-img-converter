import React, { useEffect, useRef, useState } from 'react';
import axios from 'axios';

export default function Other() {
    const [imageUrl, setImageUrl] = useState('https://m.media-amazon.com/images/I/61uyEy-KArL._AC_.jpg');
    const [uploadedUrl, setUploadedUrl] = useState('');
    const canvasRef = useRef(null);

    useEffect(() => {
        const canvas = canvasRef.current;
        const ctx = canvas.getContext('2d');
        const img = new Image();

        img.onload = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = 'white';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            const scale = Math.min(canvas.width / img.width, canvas.height / img.height);
            const newWidth = img.width * scale;
            const newHeight = img.height * scale;
            const x = (canvas.width - newWidth) / 2;
            const y = (canvas.height - newHeight) / 2;

            ctx.drawImage(img, x, y, newWidth, newHeight);
        };

        img.src = imageUrl;
    }, [imageUrl]);

    const handleChange = (e) => {
        setImageUrl(e.target.value);
    };

    const handleUpload = async () => {
        const canvas = canvasRef.current;

        canvas.toBlob(async (blob) => {
            const formData = new FormData();
            formData.append('image', blob, 'edited-image.png');

            try {
                const response = await axios.post('https://noon.bolly4u.cn/upload.php', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' },
                });

                if (response.data.success) {
                    setUploadedUrl(`https://noon.bolly4u.cn/${response.data.url}`);
                } else {
                    console.error('Error uploading the image:', response.data.error);
                }
            } catch (error) {
                console.error('Error uploading the image:', error);
            }
        }, 'image/png');
    };

    return (
        <div style={{ padding: '20px' }}>
            <h2>Image Centering, Resizing, and Uploading</h2>
            <textarea
                rows={3}
                cols={50}
                value={imageUrl}
                onChange={handleChange}
                placeholder="Enter image URL here"
                style={{
                    display: 'block',
                    marginBottom: '10px',
                    width: '100%',
                    padding: '10px',
                    fontSize: '16px',
                }}
            />
            <canvas
                ref={canvasRef}
                width={660}
                height={900}
                style={{
                    border: '1px solid #ccc',
                    display: 'block',
                    margin: '0 auto',
                }}
            ></canvas>
            <button
                onClick={handleUpload}
                style={{
                    display: 'block',
                    margin: '20px auto',
                    padding: '10px 20px',
                    backgroundColor: '#007BFF',
                    color: '#fff',
                    border: 'none',
                    borderRadius: '5px',
                }}
            >
                Upload Image
            </button>
            {uploadedUrl && (
                <div style={{ marginTop: '20px', textAlign: 'center' }}>
                    <p>Uploaded Image URL:</p>
                    <a href={uploadedUrl} target="_blank" rel="noopener noreferrer">
                        {uploadedUrl}
                    </a>
                </div>
            )}
        </div>
    );
}
