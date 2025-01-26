<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pedidos;
use App\Models\Usuarios;


class FuncionesController extends Controller
{
    //2. Recupera todos los pedidos asociados al usuario con ID 2.
    public function pedidosUsuario2(){
        $pedidos = Pedidos::where('id_usuario', 2)->get();
        return response()->json($pedidos);
    }
    
    /*3. Obtén la información detallada de los pedidos, incluyendo el nombre y correo
    electrónico de los usuarios.*/
    public function informacionPedidos(){

        /* select us.nombre as nombre_cliente,us.correo,pe.producto,pe.cantidad,pe.total
        from pedidos as pe inner join usuarios as us on pe.id_usuario=us.id;*/
        $data = Pedidos::join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
        ->select(
            'usuarios.nombre as nombre_cliente',
            'usuarios.correo',
            'pedidos.producto',
            'pedidos.cantidad',
            'pedidos.total'
        )->get();
        return response()->json($data);
    }

    //4. Recupera todos los pedidos cuyo total esté en el rango de $100 a $250.
    public function pedidosRango(){
        /*select * from pedidos  where total between 100 and 250;*/
        $data = Pedidos::whereBetween('total', [100, 250])->get();
        return response()->json($data);
    }


    //5. Encuentra todos los usuarios cuyos nombres comiencen con la letra "R".
    public function usuariosLetraR(){
        /*SELECT * FROM usuarios WHERE upper(nombre) LIKE 'R%';
        Se uso whereRaw para poder usar la funcion UPPER y LIKE en la consulta.
        */
        $data = Usuarios::whereRaw('UPPER(nombre) LIKE ?', ['R%'])->get();
        return response()->json($data);
    }


    //6. Calcula el total de registros en la tabla de pedidos para el usuario con ID 5.
    public function totalPedidosUsuario5(){
        $total = Pedidos::where('id_usuario', 5)->count();
        return response()->json($total);
    }

    /*7. Recupera todos los pedidos junto con la información de los usuarios, ordenándolos
    de forma descendente según el total del pedido.*/
    public function pedidosUsuariosOrdenados(){

        /*select us.nombre as nombre_cliente,us.correo,pe.producto,pe.cantidad,pe.total
        from pedidos as pe inner join usuarios as us on pe.id_usuario=us.id
        order by pe.total desc;*/
        $data = Pedidos::join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
        ->select(
            'usuarios.nombre as nombre_cliente',
            'usuarios.correo',
            'pedidos.producto',
            'pedidos.cantidad',
            'pedidos.total'
        )->orderBy('pedidos.total', 'desc')->get();
        return response()->json($data);
    }


    //8. Obtener la suma total del campo "total" en la tabla de pedidos.
    public function campoTotal(){
        //SELECT SUM(total) AS suma_total FROM pedidos;
        $total = Pedidos::sum('total');
        return response()->json($total);
    }


    //9. Encuentra el pedido más económico, junto con el nombre del usuario asociado.
    public function pedidoEconomico(){
        /*
        SELECT us.nombre as nombre_usuario,pe.id as id_producto,pe.producto,pe.cantidad,pe.total
        FROM pedidos as pe  inner join usuarios as us on pe.id_usuario=us.id WHERE total = (SELECT MIN(total) FROM pedidos);
        */
        //se hace uso de una subconsulta para obtener el valor del pedido mas economico
        $data = Pedidos::join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
        ->select(
            'usuarios.nombre as nombre_usuario',
            'pedidos.id as id_producto',
            'pedidos.producto',
            'pedidos.cantidad',
            'pedidos.total'
        )->where('pedidos.total', '=',Pedidos::min('total'))->first();
        return response()->json($data);
    }


    //10. Obtén el producto, la cantidad y el total de cada pedido, agrupándolos por usuario
    public function pedidosUsuario(){

        /*SELECT id_usuario,GROUP_CONCAT(producto) AS productos,SUM(cantidad) AS cantidad_total,SUM(total) AS total_pedido
        FROM pedidos GROUP BY id_usuario;*/
        
        $data= Pedidos::select('id_usuario',DB::raw('GROUP_CONCAT(producto) AS productos')
        ,DB::raw('SUM(cantidad) AS cantidad_total'),DB::raw('SUM(total) AS total_pedido')) ->groupBy('id_usuario')->get(); 
        return response()->json($data);
    }
}
