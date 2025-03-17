import { useEffect, useState } from "react";

export interface Agencia {
    fondo_1:string,
}

export const useAgencia = () => {
    const [agencia, setAgencia] = useState<Agencia | null>(null);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const fetchAgencia = async () => {
            try {
                const baseUrl = window.location.origin; // Obtiene "http://agencia.localhost:8000" dinámicamente

                const response = await fetch(`http://javi_web.localhost:8000/agencia`   ); // 👈 Revisa esta URL
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }

                const responseText = await response.clone().text(); // 👀 Verifica el contenido antes de parsear JSON
                console.log("Respuesta en texto:", responseText);

                const data = await response.json();
                console.log("Datos JSON recibidos:", data.logo);

                setAgencia(data);
            } catch (error) {
                console.error("Error al obtener la agencia:", error);
                setError(error instanceof Error ? error.message : "Error desconocido");
            }
        };

        fetchAgencia();
    }, []);

    return  agencia ;
};
