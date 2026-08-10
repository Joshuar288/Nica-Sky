document.addEventListener('DOMContentLoaded', () => {
    const departmentSelect = document.getElementById('department_select');
    const citySelect = document.getElementById('city_id');

    if (!departmentSelect || !citySelect) return;

    let allCities = [];

    try {
        const rawCities = departmentSelect.getAttribute('data-cities');
        allCities = JSON.parse(rawCities || '[]');
    } catch (error) {
        console.error('Error al parsear el listado de ciudades:', error);
    }

    departmentSelect.addEventListener('change', function () {
        const selectedDepartment = this.value;

        // Filtrar las ciudades comparando con el atributo exacto 'name_departament'
        const filteredCities = allCities.filter(
            city => String(city.name_departament).trim() === String(selectedDepartment).trim()
        );

        // Limpiar el select de municipios
        citySelect.innerHTML = '';

        // Opción por defecto
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.textContent = 'Seleccione su municipio';
        citySelect.appendChild(defaultOption);

        // Habilitar el select
        citySelect.disabled = false;

        // Llenar las opciones con 'name_city'
        filteredCities.forEach(city => {
            const option = document.createElement('option');
            option.value = city.id;
            option.textContent = city.name_city;
            citySelect.appendChild(option);
        });
    });
});