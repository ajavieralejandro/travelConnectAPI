import { createContext, useState, useContext, ReactNode, useEffect } from "react";
import { DatosAgencia } from "../interfaces/datosAgencia";

/** Definimos el tipo del contexto */
interface DatosAgenciaContextType {
  datosAgencia: DatosAgencia | null;
  cargando: boolean;
  cambiarSimulacion: (agencia: keyof typeof SIMULACIONES) => void;
}

/** Creamos el contexto */
export const DatosAgenciaContext = createContext<DatosAgenciaContextType | null>(null);

export const SIMULACIONES = {
  agencia1: {
    idAgencia: "12345",
    nombreAgencia: "Viajes Express",
    logoAgencia: "/resources/js/reactFrontTravel/assets/logos/viajes_express.png",
    tipografiaAgencia: "Arial",
    colorTipografiaAgencia: "#222222",
    colorFondoAgencia: "#F5F5F5",
    colorPrincipalAgencia: "#FF5733",
    colorSecundarioAgencia: "#33FF57",
    colorTerciarioAgencia: "#0055AA",
    terciario: "#0055AA",

    header: {
      imagenBackground: "/resources/js/reactFrontTravel/assets/header_bg.jpg",
      imagenBackgroundOpacidad: 0.8,
    },
    buscador: {
      tipografia: "Roboto",
      tipografiaColor: "#111111",
      fondoColor: "#FFFFFF",
      inputColor: "#CCCCCC",
      calendarioColorPrimario: "#FF5733",
      calendarioColorSecundario: "#33FF57",
      botonBuscarColor: "#FF5733",
      tabsColor: "#0055AA",
    },
    footer: {
      texto: "Viajes Express © 2025",
      tipografia: "Tahoma",
      tipografiaColor: "#FFFFFF",
      fondoColor: "#000000",
      iconosColor: "#FF5733",
      redes: {
        facebook: "https://facebook.com/viajesexpress",
        twitter: "https://twitter.com/viajesexpress",
      },
      datos: {
        telefono: "+54 9 11 2345 6789",
        email: "contacto@viajesexpress.com",
        ubicacion: "Buenos Aires, Argentina",
        direccion: "Av. Siempre Viva 123",
      },
    },
  },
};

/** 📌 Componente Provider */
export const DatosAgenciaProvider = ({ children }: { children: ReactNode }) => {
  const [datosAgencia, setDatosAgencia] = useState<DatosAgencia | null>(SIMULACIONES.agencia1);
  const [cargando, setCargando] = useState<boolean>(false);

  /** 📌 Función para cambiar la simulación */
  const cambiarSimulacion = (agencia: keyof typeof SIMULACIONES) => {
    setCargando(true);
    setTimeout(() => {
      setDatosAgencia(SIMULACIONES[agencia]);
      setCargando(false);
    }, 100);
  };

  return (
    <DatosAgenciaContext.Provider value={{ datosAgencia, cargando, cambiarSimulacion }}>
      {children}
    </DatosAgenciaContext.Provider>
  );
};

/** 📌 Hook general para obtener todo el contexto */
export const useDatosAgencia = () => {
  const contexto = useContext(DatosAgenciaContext);
  if (!contexto) {
    throw new Error("useDatosAgencia debe ser usado dentro de un DatosAgenciaProvider");
  }
  return contexto;
};

/** 📌 Hooks específicos para acceder a secciones individuales */
export const useDatosGenerales = () => useDatosAgencia().datosAgencia ?? null;
export const useHeader = () => useDatosAgencia().datosAgencia?.header ?? null;
export const useBuscador = () => useDatosAgencia().datosAgencia?.buscador ?? null;
export const usePublicidadCliente = () => useDatosAgencia().datosAgencia?.publicidadCliente ?? null;
export const useTarjetas = () => useDatosAgencia().datosAgencia?.tarjetas ?? null;
export const useBannerRegistro = () => useDatosAgencia().datosAgencia?.bannerRegistro ?? null;
export const useFooter = () => useDatosAgencia().datosAgencia?.footer ?? null;

/** 📌 Extendemos la interfaz `Window` al final para evitar errores con Fast Refresh */
declare global {
  interface Window {
    __DATOS_AGENCIA__?: DatosAgencia;
  }
}
