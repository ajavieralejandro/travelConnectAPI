import { DatosAgencia } from "../../interfaces/datosAgencia";
import { transformarAgenciaBackData, AgenciaBackData } from "./transformarAgenciaBackData";
import { fetchDatosAgenciaMock } from "./fetchDatosAgenciaMock";
import { fetchDatosAgenciaReal } from "./fetchDatosAgenciaReal";

const usarMock = false;

export const fetchDatosAgencia = async (): Promise<DatosAgencia> => {
  const datosBack: AgenciaBackData = usarMock
    ? await fetchDatosAgenciaMock()
    : await fetchDatosAgenciaReal();
    console.log("Los datos que estoy trayendo son : ",datosBack);
   const agencia_t =  transformarAgenciaBackData(datosBack);
   console.log("Los datos transformados son :",agencia_t);
   return agencia_t;
};
