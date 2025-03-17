import React from "react";
import { AppBar, Toolbar, Box, useMediaQuery } from "@mui/material";
import { motion } from "framer-motion";
import { useHeader, useDatosGenerales } from "../../contextos/DatosAgenciaContext";
import { useAgencia } from "../../servicios/especificos/obtenerDatosAgencia";

const Header: React.FC = () => {
  const header = useHeader();
  const datosGenerales = useDatosGenerales();
  const isMobile = useMediaQuery("(max-width: 600px)");

  if (!datosGenerales) {
    return null;
  }

  const agencia = useAgencia();

  // Verificamos que la URL de fondo_1 esté disponible antes de usarla
  const fondoImagen = agencia?.fondo_1 ? `url(${agencia.fondo_1})` : "none";
  const logo = agencia?.logo ? `${agencia.logo}` : "none";

  console.log("La agencia es :", agencia);
  console.log("el logo es : ",logo);

  /** 🔥 Normalizamos la opacidad para evitar valores incorrectos */
  const opacidad = header?.imagenBackgroundOpacidad ?? 1;
  const opacidadNormalizada = opacidad >= 0 && opacidad <= 1 ? opacidad : 1;

  return (
    <AppBar
      position="absolute"
      sx={{
        backgroundImage: fondoImagen,
        backgroundSize: "cover",
        backgroundPosition: "center",
        backgroundRepeat: "no-repeat",
        backgroundColor: !header?.imagenBackground
          ? datosGenerales.colorFondoAgencia || datosGenerales.colorPrincipalAgencia || "#F5F5F5"
          : "transparent",
        boxShadow: "none",
        height: isMobile ? "100vh" : "75vh",
        width: "100vw",
        top: 0,
        left: 0,
        margin: 0,
        padding: 0,
        overflow: "hidden",
        zIndex: 1100,
        display: "flex",
        justifyContent: "flex-start",
      }}
    >
      {/* 🔥 Capa de superposición para oscurecer la imagen sin afectar el contenido */}
      {header?.imagenBackground && (
        <Box
          sx={{
            position: "absolute",
            top: 0,
            left: 0,
            width: "100%",
            height: "100%",
            background: `linear-gradient(rgba(0,0,0,${opacidadNormalizada}), rgba(0,0,0,${
              opacidadNormalizada * 0.5
            }))`,
            zIndex: 1,
          }}
        />
      )}

      <Toolbar
        disableGutters
        sx={{
          display: "flex",
          alignItems: "flex-start",
          justifyContent: isMobile ? "center" : "flex-start",
          width: "100%",
          height: "100%",
          px: isMobile ? 0 : 4,
          pt: 2,
          position: "relative",
          zIndex: 2, // Mantiene el contenido sobre la capa oscura
        }}
      >
        <motion.div
          initial={{ opacity: 0, scale: 0.8 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 1 }}
          whileHover={{ scale: 1.2 }}
        >
          {agencia && (
            <Box
              component="img"
              src={logo}
              alt="Logo Agencia"
              onError={(e) => (e.currentTarget.style.display = "none")}
              sx={{
                height: isMobile ? 180 : 240,
                width: "auto",
                maxWidth: "750px",
                cursor: "pointer",
              }}
            />
          )}
        </motion.div>
      </Toolbar>
    </AppBar>
  );
};

export default Header;
