@extends('layouts.layout')

@section('contenido')
    <div class="grid grid-cols-6 gap-3">

        <!-- Formulario (Lado Izquierdo) -->
        <div class="col-span-2">
            <h1 class="text-3xl font-bold text-white">Lista de Productos</h1>
            <p class="text-yellow-300 italic">Bienvenido a la página de productos (CRUD API).</p>

            <div class="mt-5">
                <form id="formAlmacenApi">
                    @csrf 
                    <input type="text" id="api_nombre" placeholder="Nombre.." class="border border-gray-300 rounded py-2 px-4 w-full mt-3 text-black hover:bg-white" required>
                    <input type="text" id="api_descripcion" placeholder="Descripción..." class="border border-gray-300 rounded py-2 px-4 w-full mt-3 text-black hover:bg-white" required>
                    <input type="text" id="api_precio" placeholder="Precio..." class="border border-gray-300 rounded py-2 px-4 w-full mt-3 text-black hover:bg-white" required>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full mt-4 block text-center">
                        Guardar Producto
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabla CRUD (Lado Derecho) -->
        <div class="col-span-4">
            <table class="table-auto w-full border border-gray-100 rounded-lg shadow-md">
                <thead class="text-white bg-gray-950 bg-opacity-25 p-4">
                    <tr>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Descripción</th>
                        <th class="px-4 py-2 text-left">Precio</th>
                        <th class="px-4 py-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaAlmacenesCuerpo" class="text-white">
                    <!-- JavaScript cargará de forma automatizada las filas aquí -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // 1. LEER / LISTAR: CARGAR LA TABLA DESDE LA API CON LOS BOTONES DE ACCIÓN
        async function cargarTabla() {
            try {
                const res = await fetch('/api/almacenes/listar');
                const resultado = await res.json();
                
                if (resultado.status) {
                    let filas = '';
                    resultado.data.forEach(item => {
                        filas += `
                            <tr class="border-b border-gray-700">
                                <td class="px-4 py-2">${item.nombre}</td>
                                <td class="px-4 py-2">${item.descripcion}</td>
                                <td class="px-4 py-2">${item.precio}</td>
                                <td class="px-4 py-2 text-center flex justify-center gap-2">
                                    <button onclick="editarAlmacen(${item.id}, '${item.nombre}', '${item.descripcion}', ${item.precio})" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-1 px-2 rounded text-xs transition-colors">
                                        Editar
                                    </button>
                                    <button onclick="eliminarAlmacen(${item.id})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-xs transition-colors">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    document.getElementById('tablaAlmacenesCuerpo').innerHTML = filas;
                }
            } catch (err) {
                console.error("Error cargando tabla:", err);
            }
        }

        // Cargar datos automáticamente al inicializar la pantalla
        cargarTabla();

        // 2. CREAR / GUARDAR: ENVIAR DATOS A TRAVÉS DE LA API
        document.getElementById('formAlmacenApi').addEventListener('submit', async function(e) {
            e.preventDefault(); 
            const payload = {
                nombre: document.getElementById('api_nombre').value,
                descripcion: document.getElementById('api_descripcion').value,
                precio: document.getElementById('api_precio').value,
                _token: '{{ csrf_token() }}' 
            };
            try {
                const respuesta = await fetch('/api/almacenes/store', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const resultado = await respuesta.json();
                if (resultado.status) {
                    cargarTabla(); // Refresca la lista sin recargar la pestaña
                    document.getElementById('formAlmacenApi').reset();
                    alert(resultado.message); 
                }
            } catch (error) {
                alert('Error al guardar el registro en la API.');
            }
        });

        // 3. ACTUALIZAR / EDITAR: SOLICITAR DATOS Y ENVIAR AL CONTROLADOR
        async function editarAlmacen(id, nombreAct, descAct, precioAct) {
            const nuevoNombre = prompt("Modificar Nombre del artículo:", nombreAct);
            const nuevaDesc = prompt("Modificar Descripción del artículo:", descAct);
            const nuevoPrecio = prompt("Modificar Precio del artículo:", precioAct);

            if (nuevoNombre && nuevaDesc && nuevoPrecio) {
                try {
                    const respuesta = await fetch(`/api/almacenes/update/${id}`, {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                        body: JSON.stringify({
                            nombre: nuevoNombre,
                            descripcion: nuevaDesc,
                            precio: nuevoPrecio,
                            _token: '{{ csrf_token() }}'
                        })
                    });
                    const resultado = await respuesta.json();
                    if (resultado.status) {
                        cargarTabla(); // Renderiza de inmediato los cambios aplicados
                        alert(resultado.message);
                    }
                } catch (error) {
                    alert('Error al intentar actualizar por API.');
                }
            }
        }

        // 4. ELIMINAR / DESTRUIR: BORRAR ELEMENTO DE LA BASE DE DATOS
        async function eliminarAlmacen(id) {
            if (confirm('¿Bro, estás seguro de que quieres eliminar este registro de manera permanente de phpMyAdmin?')) {
                try {
                    const respuesta = await fetch(`/api/almacenes/delete/${id}`, {
                        method: 'DELETE',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                        body: JSON.stringify({ _token: '{{ csrf_token() }}' })
                    });
                    const resultado = await respuesta.json();
                    if (resultado.status) {
                        cargarTabla(); // Remueve la fila visualmente de inmediato
                        alert(resultado.message);
                    }
                } catch (error) {
                    alert('Error al intentar remover el registro por API.');
                }
            }
        }
    </script>
@endsection

