'use client';
import KeyboardBackspaceIcon from '@mui/icons-material/KeyboardBackspace';
import { PurpleButton } from "./PurpleButton";

export function PreviousPageButton(){
   return(
      <PurpleButton width='fit' onClick={() => history.back()}>
         <KeyboardBackspaceIcon />
         <span>Voltar</span>
      </PurpleButton>
   )
}