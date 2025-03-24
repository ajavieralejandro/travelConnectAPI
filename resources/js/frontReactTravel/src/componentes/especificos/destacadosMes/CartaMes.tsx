import React from "react";
import { Card } from "@mui/material";
import { PaqueteDestacado } from "../../../interfaces/PaqueteDestacado";
import { useTarjetas, useDatosGenerales } from "../../../contextos/DatosAgenciaContext";
import CartaMesImagen from "./CartaMesImagen";
import CartaMesContenido from "./CartaMesContenido";
import CartaMesPrecio from "./CartaMesPrecio";

interface CartaMesProps {
  paquete: PaqueteDestacado;
  estilos: {
    tarjetaTipografia: string | null;
    tarjetaTipografiaColor: string | null;
    tarjetaColorPrimario: string | null;
    tarjetaColorSecundario: string | null;
    tarjetaColorTerciario: string | null;
  };
}

const CartaMes: React.FC<CartaMesProps> = ({ paquete, estilos }) => {
  const tarjetas = useTarjetas();
  const datosGenerales = useDatosGenerales();
  const [cargando, setCargando] = React.useState(true);

  React.useEffect(() => {
    const timer = setTimeout(() => setCargando(false), 1500);
    return () => clearTimeout(timer);
  }, []);

  // Aplicar fallback en caso de valores null
  const tipografia =
    estilos.tarjetaTipografia || tarjetas?.tipografia || datosGenerales?.tipografiaAgencia || "Arial";

  const colorFondo =
    estilos.tarjetaColorSecundario || tarjetas?.color.secundario || datosGenerales?.color.secundario || "#f5f5f5";

  return (
    <Card
      sx={{
        width: "100%",
        minHeight: "100%",
        borderRadius: "16px",
        boxShadow: "0px 4px 12px rgba(0, 0, 0, 0.1)", // Sombra más difusa para evitar bordes marcados
        transition: "transform 0.3s ease-in-out",
        cursor: "pointer",
        "&:hover": { 
          transform: "scale(1.05)",
          boxShadow: "0px 8px 16px rgba(0, 0, 0, 0.15)", // Sombra más fuerte en hover
        },
        backgroundColor: colorFondo, // Fondo asegurado
        color: estilos.tarjetaTipografiaColor,
        fontFamily: tipografia,
        display: "flex",
        flexDirection: "column",
        border: "none", // 🔥 Asegura que no haya contorno
        outline: "none", // 🔥 Elimina cualquier borde enfocado por accesibilidad
      }}
    >
      <CartaMesImagen
        imagen={paquete.imagen || "/imagenes/default-image.jpg"}
        alt={paquete.nombre}
        cargando={cargando}
        colorSecundario={colorFondo}
      />

      <CartaMesContenido
        nombre={paquete.nombre}
        descripcion={paquete.descripcion}
        estilos={{
          tarjetaTipografiaColor: estilos.tarjetaTipografiaColor,
        }}
        cargando={cargando}
      />

      <CartaMesPrecio
        precio={paquete.precio}
        estilos={{
          tarjetaTipografia: estilos.tarjetaTipografia,
          tarjetaTipografiaColor: estilos.tarjetaTipografiaColor,
          tarjetaColorPrimario: estilos.tarjetaColorPrimario,
        }}
      />
    </Card>
  );
};

export default CartaMes;
