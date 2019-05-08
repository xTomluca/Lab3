window.addEventListener('load',inicializarEventos);

function inicializarEventos()
{
    document.getElementById('btnTabla').addEventListener('click',cargarTabla);
}

function cargarTabla()
{
    var personas = data;
    var tabla = document.createElement('table');
    var cabecera = document.createElement('tr');

    tabla.setAttribute('border','1px solid black');

    for(var atributo in personas[0])
    {
        var th = document.createElement('th');
        var texto = document.createTextNode(atributo);
        th.appendChild(texto);
        cabecera.appendChild(th);
    }

    tabla.appendChild(cabecera);

    for(var i in personas)
    {
        var fila = document.createElement('tr');
        var unaPersona = personas[i];
        for(var j in unaPersona)
        {
            var celdas = document.createElement('td');
            var dato = document.createTextNode(unaPersona[j]);
            celdas.appendChild(dato);
            fila.appendChild(celdas);
        }
        tabla.appendChild(fila);
    }
    document.getElementById('info').appendChild(tabla);
}