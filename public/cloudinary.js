const cloudinary = require('cloudinary');

cloudinary.v2.config({ 
  cloud_name: process.env.CLOUDINARY_CLOUD_NAME, 
  api_key: process.env.CLOUDINARY_API_KEY, 
  api_secret: process.env.CLOUDINARY_API_SECRET,
  secure: true,
});

const uploadImage = (filePath) => {
    cloudinary.uploader.upload(filePath, function(error, result) {
      console.log(result, error);
    });
  };