


function delay() {
   return new Promise(resolve => setTimeout(resolve, 2000));
}

export class ClientServices {
   private baseUrl = 'http://localhost/fotoselect/backend';

   

   public async getClients(){
      try {
         const req = await fetch(`${this.baseUrl}/client/fetchall`,
            {
               method: 'GET',
               credentials: 'include',
            }
         )
         const res = await req.json();
         if (req.status === 200) return res.content;
         return false;

      } catch (e) {
         console.log(e);
         return false;
      }
   }


}