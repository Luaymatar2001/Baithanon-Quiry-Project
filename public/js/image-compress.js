async function compressImage(file, maxWidth = 1200, quality = 0.7) {
    return new Promise((resolve) => {
        const img = new Image();
        const reader = new FileReader();

        reader.onload = (e) => {
            img.src = e.target.result;
        };

        img.onload = () => {
            const canvas = document.createElement('canvas');

            const scale = Math.min(maxWidth / img.width, 1);
            canvas.width = img.width * scale;
            canvas.height = img.height * scale;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(
                (blob) => resolve(blob),
                'image/jpeg',
                quality
            );
        };

        reader.readAsDataURL(file);
    });
}

function attachCompression() {
    document.querySelectorAll('input[type="file"]').forEach((input) => {

        const handler = async function (e) {
            const file = e.target.files[0];
            if (!file || !file.type.startsWith('image/')) return;

            const compressed = await compressImage(file, 1200, 0.7);

            const compressedFile = new File([compressed], file.name, {
                type: file.type
            });

            const dt = new DataTransfer();
            dt.items.add(compressedFile);

            input.files = dt.files;
        };

        // مهم: إزالة أي listener قديم
        input.removeEventListener('change', handler);
        input.addEventListener('change', handler);
    });
}


document.addEventListener('DOMContentLoaded', attachCompression);
document.addEventListener('livewire:update', attachCompression);
