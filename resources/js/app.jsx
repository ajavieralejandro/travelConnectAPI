import React from "react";
import ReactDOM from "react-dom/client";

function App() {
    return (
        <div style={{ textAlign: "center", marginTop: "50px" }}>
            <h1>🚀 ¡React en Laravel funcionando! 🎉</h1>
            <p>Esta es una aplicación de React renderizada en Laravel.</p>
        </div>
    );
}

ReactDOM.createRoot(document.getElementById("app")).render(<App />);
