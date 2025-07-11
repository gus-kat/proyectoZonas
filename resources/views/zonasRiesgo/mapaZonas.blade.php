@extends('layouts.app')
@section('contenido')

<br><br><br>
<script>
    let zonas = @json($zonas);
    let zonasSeguras = @json($zonasSeguras);
    let puntos = @json($puntos);
</script>

<h2 class="text-center">Mapa Global de Zonas</h2>

<div class="text-center mb-4">
    <label for="nivelFiltro" class="form-label"><b>Filtrar por nivel:</b></label>
    <select id="nivelFiltro" class="form-select-center mb-3" onchange="filtrarPorNivel()" style="max-width:250px; margin:auto;">
        <option value="todos">Todos</option>
        <option value="Bajo">Bajo</option>
        <option value="Medio">Medio</option>
        <option value="Alto">Alto</option>
    </select>

    <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
        <button class="btn btn-outline-primary" onclick="imprimirMapa()">🖨 Imprimir</button>
        <button class="btn btn-outline-danger" onclick="exportarPDF()">📄 Exportar como PDF</button>
        <button class="btn btn-outline-success" onclick="descargarImagen()">📷 Descargar Imagen</button>
    </div>
</div>

<div class="container">
    <div id="mapa-zonas" style="height:600px; width:100%; border:2px solid blue;"></div>
</div>

<script>
    let mapa;
    let elementosGraficados = [];

    function initMap() {
        mapa = new google.maps.Map(document.getElementById('mapa-zonas'), {
            center: { lat: -0.9374805, lng: -78.6161327 },
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        filtrarPorNivel();
    }

    function limpiarMapa() {
        elementosGraficados.forEach(e => e.setMap(null));
        elementosGraficados = [];
    }

    function normalizarNivel(valor) {
        switch (valor.toLowerCase()) {
            case 'baja': return 'Bajo';
            case 'media': return 'Medio';
            case 'alta': return 'Alto';
            default: return valor;
        }
    }

    function obtenerColor(nivel) {
        switch (nivel) {
            case 'Bajo': return '#44FF44';
            case 'Medio': return '#FFB800';
            case 'Alto': return '#3399FF';
            default: return '#999999';
        }
    }

    function filtrarPorNivel() {
        limpiarMapa();
        const nivelFiltro = document.getElementById("nivelFiltro").value;

        zonas.forEach(z => {
            const nivelZona = normalizarNivel(z.nivelRiesgo || '');
            if (nivelFiltro === 'todos' || nivelZona === nivelFiltro) {
                const coords = [
                    { lat: parseFloat(z.latitud1), lng: parseFloat(z.longitud1) },
                    { lat: parseFloat(z.latitud2), lng: parseFloat(z.longitud2) },
                    { lat: parseFloat(z.latitud3), lng: parseFloat(z.longitud3) },
                    { lat: parseFloat(z.latitud4), lng: parseFloat(z.longitud4) }
                ];
                const poligono = new google.maps.Polygon({
                    paths: coords,
                    strokeColor: "#FF0000",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#FF0000",
                    fillOpacity: 0.35,
                    map: mapa
                });
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div style="max-width:230px;font-size:14px;">
                            <h6 style="font-weight:bold;">Zona de Riesgo</h6>
                            <p><strong>Nombre:</strong> ${z.nombre || 'Sin nombre'}</p>
                            <p><strong>Nivel:</strong> ${nivelZona}</p>
                        </div>
                    `
                });
                poligono.addListener('click', () => {
                    infoWindow.setPosition(coords[0]);
                    infoWindow.open(mapa);
                });
                elementosGraficados.push(poligono);
            }
        });

        zonasSeguras.forEach(z => {
            const nivelZona = normalizarNivel(z.tipo || '');
            if (nivelFiltro === 'todos' || nivelZona === nivelFiltro) {
                const centro = { lat: parseFloat(z.latitud), lng: parseFloat(z.longitud) };
                const color = obtenerColor(nivelZona);
                const radio = parseFloat(z.radio) || 50;
                const circulo = new google.maps.Circle({
                    strokeColor: "#000000",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: color,
                    fillOpacity: 0.4,
                    map: mapa,
                    center: centro,
                    radius: radio
                });
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div style="max-width:230px;font-size:14px;">
                            <h6 style="font-weight:bold;">Zona Segura</h6>
                            <p><strong>Nombre:</strong> ${z.nombre || 'Sin nombre'}</p>
                            <p><strong>Nivel:</strong> ${nivelZona}</p>
                            <p><strong>Radio:</strong> ${z.radio}</p>
                        </div>
                    `
                });
                circulo.addListener('click', () => {
                    infoWindow.setPosition(centro);
                    infoWindow.open(mapa);
                });
                elementosGraficados.push(circulo);
            }
        });

        puntos.forEach(p => {
            const posicion = { lat: parseFloat(p.latitud), lng: parseFloat(p.longitud) };
            const marcador = new google.maps.Marker({
                position: posicion,
                map: mapa,
                title: p.nombre || 'Punto de Encuentro',
                icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
            });
            const imagenHTML = (p.imagen && p.imagen !== 'sin imagen')
                ? `<div style="text-align:center;">
                    <img src="/storage/${p.imagen}" alt="Imagen"
                         style="width:100%;max-width:160px;height:auto;border-radius:6px;object-fit:cover;">
                   </div>`
                : `<p><em>Sin imagen</em></p>`;
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="max-width:250px;font-size:14px;">
                        ${imagenHTML}
                        <h6 style="margin-top:8px;font-weight:bold;">${p.nombre}</h6>
                        <p><strong>Capacidad:</strong> ${p.capacidad}</p>
                        <p><strong>Responsable:</strong> ${p.responsable}</p>
                    </div>
                `
            });
            marcador.addListener('click', () => {
                infoWindow.open(mapa, marcador);
            });
            elementosGraficados.push(marcador);
        });
    }

    function descargarImagen() {
        html2canvas(document.getElementById('mapa-zonas'), { useCORS: true }).then(canvas => {
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = 'mapa-zonas.png';
            link.click();
        });
    }

    function exportarPDF() {
        html2canvas(document.getElementById('mapa-zonas'), { useCORS: true }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jspdf.jsPDF('landscape', 'pt', [canvas.width, canvas.height]);
            pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
            pdf.save("mapa-zonas.pdf");
        });
    }

    function imprimirMapa() {
        html2canvas(document.getElementById('mapa-zonas'), { useCORS: true }).then(canvas => {
            const dataUrl = canvas.toDataURL('image/png');
            const ventana = window.open('', '', 'width=900,height=700');
            ventana.document.write('<html><head><title>Imprimir Mapa</title></head><body style="text-align:center;">');
            ventana.document.write(`<img src="${dataUrl}" style="max-width:100%;height:auto;">`);
            ventana.document.write('</body></html>');
            ventana.document.close();
            ventana.focus();
            ventana.print();
            ventana.close();
        });
    }
</script>

<!-- Google Maps API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuXfFTd694L_jf7x67Z5kAuv4IbtHnfFs&callback=initMap"></script>

<!-- Librerías para captura y PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<br><br><br>
@endsection
