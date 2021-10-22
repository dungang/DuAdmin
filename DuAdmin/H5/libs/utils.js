 const compress = (image, maxH = 160) => {
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

 const kmFormat = (distance) => {
     if (distance < 1000)
         return distance + "米";
     else if (distance > 1000)
         return (Math.round(distance / 100) / 10).toFixed(1) + "公里";
 }

 const secondFormat = (value) => {
     var theTime = parseInt(value); // 需要转换的时间秒 
     var theTime1 = 0; // 分 
     var theTime2 = 0; // 小时 
     var theTime3 = 0; // 天
     if (theTime > 60) {
         theTime1 = parseInt(theTime / 60);
         theTime = parseInt(theTime % 60);
         if (theTime1 > 60) {
             theTime2 = parseInt(theTime1 / 60);
             theTime1 = parseInt(theTime1 % 60);
             if (theTime2 > 24) {
                 //大于24小时
                 theTime3 = parseInt(theTime2 / 24);
                 theTime2 = parseInt(theTime2 % 24);
             }
         }
     }
     var result = '';
     if (theTime > 0) {
         result = "" + parseInt(theTime) + "秒";
     }
     if (theTime1 > 0) {
         result = "" + parseInt(theTime1) + "分" + result;
     }
     if (theTime2 > 0) {
         result = "" + parseInt(theTime2) + "小时" + result;
     }
     if (theTime3 > 0) {
         result = "" + parseInt(theTime3) + "天" + result;
     }
     return result;
 }

 export default {
     compress,
     secondFormat,
     kmFormat
 }