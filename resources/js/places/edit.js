import Validator from '../validator'

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('validacion-places-edit');

    if (form) {
        form.addEventListener('submit', function(event) {
            // Resetea los mensajes de error
            document.querySelectorAll('.error-message').forEach((div) => {
                div.style.display = 'none';
            });

            // Obtiene los valores del formulario
            const formData = {
                name: document.getElementById('name').value,
                description: document.getElementById('description').value,
                latitude: document.getElementById('latitude').value,
                longitude: document.getElementById('longitude').value,
                visibility_id: document.getElementById('visibility_id').value,
                upload: document.getElementById('upload').value,
            };

            // Define las reglas de validación
            const rules = {
                name: 'required',
                description: 'required',
                latitude: 'required',
                longitude: 'required',
                visibility_id: 'required',
                upload: 'required',
            };

            // Crea la validación
            const validation = new Validator(formData, rules);

            // Valida los campos
            if (!validation.passes()) {
                const errors = validation.errors.all();

                // Muestra los mensajes de error
                for (const field in errors) {
                    const errorDiv = document.getElementById(`${field}-error`);
                    errorDiv.innerText = errors[field];
                    errorDiv.style.display = 'block';
                }

                // Evita el envío del formulario
                event.preventDefault();
            }
        });
    }
});
