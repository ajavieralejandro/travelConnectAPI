export interface DatosAgencia {
  /** 🔥 Datos Generales */
  idAgencia: string;
  nombreAgencia: string;
  logoAgencia: string | null;
  tipografiaAgencia: string | null;
  colorTipografiaAgencia: string | null;
  colorFondoApp: string | null;
  color: {
    primario: string | null;
    secundario: string | null;
    terciario: string | null;
  };

  /** 🔥 Header */
  header: {
    imagenBackground: string | null;
    imagenBackgroundOpacidad: number | null;
    videoBackground: string | null;
    videoBackgroundOpacidad: number | null;
  };

  /** 🔥 Buscador */
  buscador: {
    tipografia: string | null;
    tipografiaColor: string | null;
    tipografiaColorLabel: string | null;
    color: {
      primario: string | null;
      secundario: string | null;
      terciario: string | null;
    };
  };

  /** 🔥 Publicidad Cliente */
  publicidadCliente: {
    existe: boolean;
    titulo: string | null;
    tipografiaColor: string | null;
    color: {
      primario: string | null;
      secundario: string | null;
      terciario: string | null;
    };
    imagenes: [string | null, string | null, string | null];
  };

  /** 🔥 Tarjetas (antes Destacados del Mes) */
  tarjetas: {
    titulo: string | null;
    tipografia: string | null;
    tipografiaColor: string | null;
    tipografiaColorTitulo: string | null;
    tipografiaColorContenido: string | null;
    color: {
      primario: string | null;
      secundario: string | null;
      terciario: string | null;
    };
  };

  /** 🔥 Banner de Registro */
  bannerRegistro: {
    titulo: string | null;           // ✅ Añadido
    tipografiaColor: string | null;      // ✅ Añadido
    color: {
      primario: string | null;
      secundario: string | null;
      terciario: string | null;
    };
  };

  /** 🔥 Footer */
  footer: {
    texto: string | null;
    tipografia: string | null;
    tipografiaColor: string | null;
    color: {
      primario: string | null;
      secundario: string | null;
      terciario: string | null;
    };
    redes: {
      facebook: string | null;
      twitter: string | null;
      instagram: string | null;
      whatsapp: string | null;
    };
    contacto: {
      telefono: string | null;
      email: string | null;
    };
    ubicacion: {
      direccion: string | null;
      ciudad: string | null;
      pais: string | null;
    };
  };
}
