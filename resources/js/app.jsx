import React, { useEffect, useState } from 'react';
import ReactDOM from "react-dom/client";




function App() {
    const [tenant, setTenant] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        // Cambia 'tenant1.example.com' por el dominio que desees consultar
        const subdomain = window.location.hostname.split('.')[0]; // Assuming subdomain is the first part

  // Construct the URL dynamically using the subdomain
    const url = `http://127.0.0.1:8000/tenants/${subdomain}`;

        fetch(url)
          .then((response) => {
            if (!response.ok) {
              throw new Error('Tenant no encontrado');
            }
            return response.json();
          })
          .then((data) => {
            setTenant(data);
            console.log("El tenant es :",data);
            setLoading(false);
          })
          .catch((error) => {
            setError(error.message);
            setLoading(false);
          });
      }, []);

    return (
        <div style={{ textAlign: "center", marginTop: "50px" }}>
            <h1>🚀 ¡React en Laravel funcionando! 🎉</h1>
            <p>Esta es una aplicación de React renderizada en Laravel.</p>
            {loading ? (
                <p>Cargando...</p>
            ) : error ? (
                <p style={{ color: "red" }}>Error: {error}</p>
            ) : tenant ? (
                <p>El subdominio del tenant es: <strong>{tenant.subdomain}</strong></p>
            ) : (
                <p>No se encontró el tenant.</p>
            )}

        </div>
    );
}

ReactDOM.createRoot(document.getElementById("app")).render(<App />);
