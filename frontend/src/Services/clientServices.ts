

type registerNewClientObj = {
   profile_image: File | null,
   name: string,
   email: string,
   phone: string | null,
   password: string
}

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

   public async registerClient(client: registerNewClientObj){
      try {
         const formData = new FormData();
         formData.append('profile_image', client.profile_image[0]);
         formData.append('name', client.name);
         formData.append('email', client.email);
         formData.append('phone', client.phone);
         formData.append('password', client.password);

         const req = await fetch(`${this.baseUrl}/client/register`,
            {
               method: 'POST',
               credentials: 'include',
               body: formData
            }
         )
         const res = await req.json();
         if (req.status === 201) return true;
         return false;

      } catch (e) {
         console.log(e);
         return false;
      }
   }

   public async deleteClient(clientId: number){
      try {
         const req = await fetch(`${this.baseUrl}/client/delete`,
            {
               method: 'DELETE',
               credentials: 'include',
               headers: {'Content-Type': 'application/json'},
               body: JSON.stringify({client_id: clientId})
            }
         )
         const res = await req.json();
         if (req.status === 200) return true;
         return false;

      } catch (e) {
         console.log(e);
         return false;
      }
   }


}