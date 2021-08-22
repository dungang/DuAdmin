export const compress = (image, maxH = 160) => {
    return new Promise(function(resolve, reject) {
        try {
            let img = new Image();
            img.onload = () => {
                let cvs = document.createElement('canvas'),
                    ctx = cvs.getContext('2d');
                if (img.height > maxH) {
                    img.width *= maxH / img.height;
                    img.height = maxH;
                }
                cvs.width = img.width;
                cvs.height = img.height;
                ctx.clearRect(0, 0, cvs.width, cvs.height);
                ctx.drawImage(img, 0, 0, img.width, img.height);
                cvs.toBlob((data) => {
                    resolve(data)
                }, 'image/jpeg', 0.6)
            }
            img.src = image;
        } catch (e) {
            console.log(e);
            reject(new Error(e.getMessage()));
        }
    });
}