import { AgenciaBackData } from "./transformarAgenciaBackData";

export const fetchDatosAgenciaReal = async (): Promise<AgenciaBackData> => {
    const url = `${window.location.origin}/agencia`;
  const response = await fetch(url, {
    headers: { Accept: "application/json" },
  });

  if (!response.ok) {
    throw new Error("No se pudo obtener la información de la agencia");
  }

  return await response.json();
};
