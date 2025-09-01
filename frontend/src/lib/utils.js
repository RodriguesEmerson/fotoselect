

export class Utils{
   validadeImages(files){
      const ACCEPTED_MIME_TYPES = ["image/jpeg", "image/png"];
      const MAX_SIZE = 1_000_000 //1MB;
      const MIN_SIZE = 10_000 //10KB;
      const validImages = [];
      const invalidImages = [];

      files.forEach(file => {
         if(!ACCEPTED_MIME_TYPES.includes(file.type)){
            return invalidImages.push({
               name: file.name,
               reason: `Imagens do tipo (${file.type.split('/')[1]}) não são permitidas.`
            });
         }
         if(file.size > MAX_SIZE){
            return invalidImages.push({
               name: file.name,
               reason: `Tamanho maior que o permitido de 1MB | (${(file.size / 1024 / 1024).toFixed(2)}MB)`
            });
         }
         if(file.size < MIN_SIZE){
            return invalidImages.push({
               name: file.name,
               reason: `Tamanho menor que o permitido de 10KB | (${(file.size / 1024 / 1024).toFixed(2)}MB)`
            });
         }

         validImages.push(file);
      })

      return { validImages: validImages, invalidImages: invalidImages}
   }
}