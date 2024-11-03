<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ImgBB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const uploadStatus = document.getElementById("uploadStatus");
            const csrfToken = "{{ csrf_token() }}";

            function handleFiles(files) {
                if (files.length > 0) {
                    const formData = new FormData();
                    formData.append('image', files[0]);

                    fetch("{{ route('upload.store') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Kiểm tra loại tệp và hiển thị thông báo hoặc video
                                if (data.type && data.type.includes('video')) {
                                    uploadStatus.innerHTML = `<video width="320" height="240" controls>
                                                            <source src="/storage/${data.path}" type="video/${data.type}">
                                                            Your browser does not support the video tag.
                                                         </video>`;
                                } else {
                                    uploadStatus.innerHTML = `<p class="text-green-500">${data.success}</p>`;
                                }
                            } else {
                                uploadStatus.innerHTML = `<p class="text-red-500">Upload failed. Please try again.</p>`;
                            }
                        })
                        .catch(error => {
                            uploadStatus.innerHTML = `<p class="text-red-500">Upload failed. Please try again.</p>`;
                        });
                }
            }

            const uploadBox = document.getElementById("uploadBox");

            // Event listener cho kéo-thả
            uploadBox.addEventListener("dragover", function(event) {
                event.preventDefault();
                uploadBox.classList.add("border-blue-500"); // Highlight khi kéo vào
            });

            uploadBox.addEventListener("dragleave", function(event) {
                uploadBox.classList.remove("border-blue-500"); // Xóa highlight khi rời
            });

            uploadBox.addEventListener("drop", function(event) {
                event.preventDefault();
                uploadBox.classList.remove("border-blue-500");
                handleFiles(event.dataTransfer.files);
            });

            // Event listener cho paste
            uploadBox.addEventListener("paste", function(event) {
                handleFiles(event.clipboardData.files);
            });
        });
    </script>
</head>

<body class="bg-gray-100">
    <header class="flex justify-between items-center p-4 border-b">
        <div class="flex items-center space-x-2">
            <i class="fas fa-question-circle"></i>
            <span>Giới thiệu</span>
        </div>
        <div class="flex items-center space-x-2">
            <i class="fas fa-language"></i>
            <span>VI</span>
        </div>
        <div class="flex items-center space-x-2">
            <i class="fas fa-cloud-upload-alt"></i>
            <span>Tải lên</span>
        </div>
    </header>
    <main class="flex flex-col items-center justify-center h-screen">
        <div class="text-center">
            <div id="uploadBox" class="border-dashed border-4 border-gray-400 p-10 rounded-lg cursor-pointer">
                <img src="https://storage.googleapis.com/a1aa/image/f36E7ERe96lnN0Cm4r4yu7cVEGUgGu2bPpVvIdjYfqZezJ1OB.jpg" alt="Cloud upload icon" class="mx-auto mb-4" height="100" width="100" />
                <p class="text-lg">Kéo thả hoặc paste (Ctrl + V) ảnh hoặc video vào đây để tải lên</p>
                <p class="text-sm text-gray-500">Bạn có thể <a class="text-blue-500" href="#">tải lên từ máy tính</a> hoặc <a class="text-blue-500" href="#">thêm địa chỉ ảnh</a>.</p>
            </div>
            <div id="uploadStatus" class="mt-4"></div>
        </div>
    </main>
    <footer class="bg-gray-800 text-white text-center p-4">
        <p>ImgBB Pro account</p>
        <p>ImgBB is a free image hosting service. Upgrade to unlock all the features.</p>
    </footer>
</body>

</html>