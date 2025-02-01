<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AM Green Image Converter</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="antialiased">
    <header>
        <nav class="border-gray-200 py-2.5 flex justify-between cursor-pointer w-11/12 m-auto max-w-[1400px] mx-auto"><a to="/" class="flex items-center"><img src="https://noon-img-converter.vercel.app/logo.png" class="mr-3 h-6 sm:h-9" alt="Logo"><span class="self-center text-xl font-semibold whitespace-nowraptext-white">AM Green Image Converter</span></a></nav>
    </header>

    <div class="font-poppins w-11/12 m-auto max-w-[1400px] mx-auto py-10">
        <h1 class="text-4xl mb-5">Converter :</h1>
        <div class="grid md:grid-cols-2 gap-10">
            {{-- Left Side - Input --}}
            <div>
                <div class="w-full lg:w-auto">
                    <div class="flex justify-between items-center mb-3">
                        <label class="text-[24px]">ADD LIST</label>
                        <form class="max-w-sm flex items-center gap-3">
                            <label class="text-sm font-medium">Dimensions</label>
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5"
                                id="dimensions">
                                <option value="660 X 900">660 X 900</option>
                                <option value="800 X 1200">800 X 1200</option>
                            </select>
                        </form>
                    </div>

                    <div class="flex items-center gap-3 mb-3">
                        <input type="checkbox" id="addLogo" />
                        <label for="addLogo">Add Logo</label>
                        <input type="file" id="logoFile" accept="image/*" />
                        <select
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5"
                            id="logoPosition">
                            <option value="top-left">Top Left</option>
                            <option value="top-right">Top Right</option>
                            <option value="bottom-left">Bottom Left</option>
                            <option value="bottom-right">Bottom Right</option>
                            <option value="center">Center</option>
                        </select>
                    </div>

                    <textarea id="inputValue" rows="10" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"></textarea>
                    <div class="mt-3 text-end">
                        <button
                            type="button"
                            id="convertButton"
                            class="bg-blue-700 text-white hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center">
                            <svg id="loadingSpinner" class="hidden w-5 h-5 mr-2 text-white animate-spin" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-linecap="round"
                                    class="opacity-25"></circle>
                                <path fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A8 8 0 0112 20v4c-3.632 0-6.896-1.513-9.293-3.909l2.707-2.8z"
                                    class="opacity-75"></path>
                            </svg>
                            <span id="convertText">Convert</span>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <label class="text-[24px] mb-3">
                    YOUR LIST (<span id="count">0</span>) | Converted (<span id="convertedCount">0</span>)
                </label>
                <textarea id="outputValue" rows="10" cols="30" disabled class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="Valid numbers will appear here"></textarea>
                <div class="mt-3 text-end">
                    <button
                        type="button"
                        id="copyButton"
                        class="text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5">
                        Copy
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden">
        <canvas id="canvas"></canvas>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputValue = document.getElementById('inputValue');
            const outputValue = document.getElementById('outputValue');
            const convertButton = document.getElementById('convertButton');
            const copyButton = document.getElementById('copyButton');
            const count = document.getElementById('count');
            const addLogo = document.getElementById('addLogo');
            const logoFile = document.getElementById('logoFile');
            const logoPosition = document.getElementById('logoPosition');
            const dimensions = document.getElementById('dimensions');

            const processImage = async (imageUrl, logo, logoPosition, canvasWidth, canvasHeight) => {
                return new Promise((resolve, reject) => {
                    const ctx = canvas.getContext('2d');
                    const img = new Image();
                    img.crossOrigin = 'anonymous';
                    img.onload = async () => {
                        canvas.width = canvasWidth;
                        canvas.height = canvasHeight;
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        ctx.fillStyle = 'white';
                        ctx.fillRect(0, 0, canvas.width, canvas.height);

                        const scale = Math.min(canvas.width / img.width, canvas.height / img.height);
                        const newWidth = img.width * scale;
                        const newHeight = img.height * scale;
                        const x = (canvas.width - newWidth) / 2;
                        const y = (canvas.height - newHeight) / 2;
                        ctx.drawImage(img, x, y, newWidth, newHeight);

                        if (logo) {
                            const logoImg = new Image();
                            logoImg.src = URL.createObjectURL(logo);
                            logoImg.onload = () => {
                                const logoSize = 100;
                                let logoX = 0,
                                    logoY = 0;

                                switch (logoPosition) {
                                    case 'top-left':
                                        logoX = 10;
                                        logoY = 10;
                                        break;
                                    case 'top-right':
                                        logoX = canvas.width - logoSize - 10;
                                        logoY = 10;
                                        break;
                                    case 'bottom-left':
                                        logoX = 10;
                                        logoY = canvas.height - logoSize - 10;
                                        break;
                                    case 'bottom-right':
                                        logoX = canvas.width - logoSize - 10;
                                        logoY = canvas.height - logoSize - 10;
                                        break;
                                    case 'center':
                                        logoX = (canvas.width - logoSize) / 2;
                                        logoY = (canvas.height - logoSize) / 2;
                                        break;
                                }

                                ctx.drawImage(logoImg, logoX, logoY, logoSize, logoSize);
                                resolve(canvas.toDataURL('image/png'));
                            };
                        } else {
                            resolve(canvas.toDataURL('image/png'));
                        }
                    };

                    img.onerror = () => reject('Failed to load image.');
                    img.src = imageUrl;
                });
            };


            // convertButton.addEventListener('click', async function() {
            //     convertButton.disabled = true;
            //     document.getElementById('loadingSpinner').classList.remove('hidden');
            //     document.getElementById('convertText').textContent = 'Converting...';
            //     const inputLines = inputValue.value.split('\n');
            //     const selectedDimensions = dimensions.value.split(' X ').map(Number);
            //     const logo = addLogo.checked ? logoFile.files[0] : null;
            //     console.log(selectedDimensions)
            //     let outputLines = [];
            //     for (let line of inputLines) {
            //         if (line.includes('ikea.com') || line.includes("myipadbox")) {
            //             try {
            //                 const formData = new FormData();
            //                 formData.append('url', line.replace(/(\.[a-zA-Z]{3,4})(\?.*)?$/, "$1"));
            //                 if (logo) formData.append('logo', logo);
            //                 if (logoPosition) formData.append('logoPosition', logoPosition.value);
            //                 if (dimensions) formData.append('dimensions', dimensions);
            //                 console.log(dimensions)
            //                 const response = await fetch('https://noon.bolly4u.cn/api/upload-from-url', {
            //                     method: 'POST',
            //                     body: formData
            //                 });
            //                 const result = await response.json();
            //                 if (result.success) {
            //                     outputLines.push(result.url);
            //                 } else {
            //                     alert('Failed to process IKEA image.');
            //                 }
            //             } catch (error) {
            //                 alert('Error processing IKEA image.');
            //             }
            //         } else {
            //             const match = line.match(/^(.*?_AC_).*?(\.[a-zA-Z]{3,4})$/);
            //             if (match) {
            //                 const modifiedUrl = `${match[1]}US_${match[2]}`;
            //                 console.log(modifiedUrl)
            //                 try {
            //                     const processedImage = await processImage(modifiedUrl, logo, logoPosition.value, selectedDimensions[0], selectedDimensions[1]);

            //                     const base64Data = processedImage.split(',')[1]; // Strip the data URL prefix.
            //                     const byteCharacters = atob(base64Data);
            //                     const byteNumbers = new Array(byteCharacters.length).fill(0).map((_, i) => byteCharacters.charCodeAt(i));
            //                     const byteArray = new Uint8Array(byteNumbers);
            //                     const blob = new Blob([byteArray], {
            //                         type: 'image/png'
            //                     });

            //                     const formData = new FormData();
            //                     formData.append('image', blob, 'processed_image.png');


            //                     // const formData = new FormData();
            //                     // formData.append('image', processedImage);
            //                     const response = await fetch('https://noon.bolly4u.cn/api/upload-file', {
            //                         method: 'POST',
            //                         body: formData
            //                     });
            //                     const result = await response.json();
            //                     if (result.success) {
            //                         outputLines.push(result.url);
            //                     } else {
            //                         alert('Image upload failed.');
            //                     }
            //                 } catch (error) {
            //                     console.log(error)
            //                     alert('Error uploading image.');
            //                 }
            //             }
            //         }
            //     }

            //     outputValue.value = outputLines.join('\n');
            //     count.textContent = outputLines.length;
            //     convertButton.disabled = false;
            //     document.getElementById('loadingSpinner').classList.add('hidden');
            //     document.getElementById('convertText').textContent = 'Convert';
            // });

            convertButton.addEventListener('click', async function() {
                // Disable button and show loading state
                convertButton.disabled = true;
                document.getElementById('loadingSpinner').classList.remove('hidden');
                document.getElementById('convertText').textContent = 'Converting...';

                const inputLines = inputValue.value.split('\n');
                const selectedDimensions = dimensions.value.split(' X ').map(Number);
                const logo = addLogo.checked ? logoFile.files[0] : null;

                let outputLines = [];
                let convertedCount = 0; // Track number of converted images

                for (let i = 0; i < inputLines.length; i++) {
                    const line = inputLines[i];

                    try {
                        let processedUrl = null;

                        if (line.includes('ikea.com') || line.includes("myipadbox")) {
                            const formData = new FormData();
                            formData.append('url', line.replace(/(\.[a-zA-Z]{3,4})(\?.*)?$/, "$1"));
                            if (logo) formData.append('logo', logo);
                            if (logoPosition) formData.append('logoPosition', logoPosition.value);
                            if (dimensions) formData.append('dimensions', dimensions);

                            const response = await fetch('https://noon.bolly4u.cn/api/upload-from-url', {
                                method: 'POST',
                                body: formData
                            });

                            const result = await response.json();
                            if (result.success) {
                                processedUrl = result.url;
                            }
                        } else {
                            const match = line.match(/^(.*?_AC_).*?(\.[a-zA-Z]{3,4})$/);
                            if (match) {
                                const modifiedUrl = `${match[1]}US_${match[2]}`;
                                try {
                                    const processedImage = await processImage(modifiedUrl, logo, logoPosition.value, selectedDimensions[0], selectedDimensions[1]);

                                    const base64Data = processedImage.split(',')[1];
                                    const byteCharacters = atob(base64Data);
                                    const byteNumbers = new Array(byteCharacters.length).fill(0).map((_, i) => byteCharacters.charCodeAt(i));
                                    const byteArray = new Uint8Array(byteNumbers);
                                    const blob = new Blob([byteArray], {
                                        type: 'image/png'
                                    });

                                    const formData = new FormData();
                                    formData.append('image', blob, 'processed_image.png');

                                    const response = await fetch('https://noon.bolly4u.cn/api/upload-file', {
                                        method: 'POST',
                                        body: formData
                                    });

                                    const result = await response.json();
                                    if (result.success) {
                                        processedUrl = result.url;
                                    }
                                } catch (error) {
                                    console.log(error);
                                }
                            }
                        }

                        if (processedUrl) {
                            outputLines.push(processedUrl);
                            convertedCount++; // Increment converted count
                            outputValue.value += processedUrl + '\n'; // Show data side by side
                            count.textContent = outputLines.length;
                            document.getElementById('convertedCount').textContent = convertedCount; // Update converted count
                        }

                    } catch (error) {
                        console.log(error);
                    }
                }

                // Restore button state
                convertButton.disabled = false;
                document.getElementById('loadingSpinner').classList.add('hidden');
                document.getElementById('convertText').textContent = 'Convert';
            });


            copyButton.addEventListener('click', function() {
                navigator.clipboard.writeText(outputValue.value)
                    .then(() => alert('Copied to clipboard!'))
                    .catch(() => alert('Failed to copy'));
            });
        });
    </script>


</body>

</html>