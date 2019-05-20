/*// nodejs server.js - http://localhost:3000/traer/?collection=personas - (live server) http://127.0.0.1:5500/index.html
//document.querySelector('#miId').addEventListener('click',cargarData);
//window.onload = cargarData;

//function cargarData() {
window.onload = function(){

    const xhr = new XMLHttpRequest();
    xhr.open('GET','http://localhost:3000/traer/?collection=personas',true);
    xhr.onload = function(){
        if(this.status === 200){
            //console.log(JSON.parse(this.responseText));
            const nombres = JSON.parse(this.responseText);
            //agarro el body
            var body = document.querySelector("body");
            //creo tag tabla
            var tabla = document.createElement("table");
            //creo encabezado
            var thead = document.createElement("thead");
            var trhead = document.createElement("tr");
            console.log(nombres);
            for(var j=0;j<Object.keys(nombres[0]).length;j++){
                //creo td
                var td = document.createElement("td");
                var text =document.createTextNode(Object.keys(nombres[0])[j]);
                td.appendChild(text);
                trhead.appendChild(td);
            }
            thead.appendChild(trhead);
            //forma 1 de agregar el thead:
            //tabla.appendChild(thead);
        
            //recorro los datos
            for(var i=0;i<nombres.length;i++){
                //creo tr por cada objeto
                var tr = document.createElement("tr");
                for(var j=0;j<Object.keys(nombres[i]).length;j++){
                    //creo td por cada atributo
                    var td = document.createElement("td");
                    //podria agregar aca el manejador de evento, pero lo hago al final, con toda la tabla ya creada
                    var text =document.createTextNode(Object.values(nombres[i])[j]);
                    td.appendChild(text);
                    tr.appendChild(td);
                }
                //agrego la tr con los datos a la tabla
                tabla.appendChild(tr);
            }
            //al final de la iteracion la tabla tiene todos sus datos.
            //forma 2 de agregar el thead:
            tabla.firstChild.before(thead);
            //agrego estilo a la tabla
            tabla.classList.add("borde");
        
            //inserto la tabla en el body
            body.appendChild(tabla);
            //una vez que esta "appendeada" la tabla, la puedo consultar.
            thead = document.querySelector("table thead");
            for(var i=0;i<thead.querySelectorAll("td").length;i++){
                //recorro todos los "td" dentro del "thead" para poner en mayusculas el textContent
                thead.querySelectorAll("td")[i].textContent = thead.querySelectorAll("td")[i].textContent.toUpperCase();
            }
            //agrego manejador de eventos a todos los td
            if(body.hasChildNodes){
                recorrerDOM(body,function(node){
                    if(node.nodeName == "TD"){
                        node.addEventListener("click",function(e){
                            //recupero el ID(asumiendo ID siempre en la primera columna)
                            var id = console.log(e.target.parentNode.firstChild.textContent);
                        })
                    }
                })
            }    
        }
    }
    xhr.send();
}

function recorrerDOM(node, func) {
    func(node);
    node = node.firstChild;
    while (node) {
        recorrerDOM(node, func);
        node = node.nextSibling;
    }
}*/

window.onload = function(){
    const xhr = new XMLHttpRequest();
    xhr.open('GET','http://localhost:3000/traer/?collection=personas',true);
    xhr.onload = function(){
        if(this.status=== 200)
        {
            const nombre = JSON.parse(this.responseText);
            //CREO BODY
            var body = document.querySelector("body");
            
            //Creo tabla
            var tabla = document.createElement("table");
            
            //CREO CABECERA
            var thead = document.createElement("th");
            var trhead = document.createElement("tr");
            
            for(i=0;i<Object.keys(nombre[0]).length;i++)
            {
                var td = document.createElement("td");
                var textHead = document.createTextNode(Object.keys(nombre[0])[i]);
            
                td.appendChild(textHead);
                trhead.appendChild(td);
            
            
            }
            thead.appendChild(trhead);
            tabla.appendChild(thead);
            
            for(i=0;i<nombre.length;i++)
            {
                var tr = document.createElement("tr");
                for(j=0;Object.keys(nombre[i]).length;j++)
                {
                    var td = document.createElement("td");
                    var textData = document.createTextNode(Object.values(nombre[i])[j]);
                    td.appendChild(textData);
                    tr.appendChild(td);
                }
                tabla.appendChild(tr);
            }
            tabla.classList.add("borde");
            body.appendChild(tabla);
        }
    }
    xhr.send();
}