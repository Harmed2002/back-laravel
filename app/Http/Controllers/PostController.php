<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

    public function index() {}

	public function UserPosts(Request $request)
	{
		// Obtengo el usuario autenticado
		$user = Auth::user();

		if ($user) {
			// Obtengo los posts del usuario
			$posts = $user->posts;

			return response()->json($posts, 200);
		}
	}

    public function store(Request $request)
	{
		// Validamos los datos
		$request->validate([
			"title" => "required"
		]);

        // Obtenemos el usr
        $user_id = auth()->user()->id;
		// Guardamos
		$post = new Post();
        $post->user_id = $user_id;
		$post->title = $request->title;
		$post->content = $request->content;
		$post->save();

		// Respuesta
		return response()->json(["message" => "Post registrado"], 201);
	}

    // public function update(Request $request, string $id)
    public function update(Request $request)
	{
		// Se validan los datos
		$request->validate([
			"title" => "required"
		]);

        $id = $request->id;

		// Se busca el producto a modificar
		$post = Post::findOrFail($id);

		// Guardamos
		$post->title = $request->title;
		$post->content = $request->content;
		$post->update();

		// Respuesta
		return response()->json(["message" => "Post actualizado"], 201);
	}

    public function destroy($id)
	{
		// Se busca el producto a eliminar
		$post = Post::find($id);
        if (!$post) {
            return response()->json(["error" => "Post not found"], 404);
        }

		$post->delete();

		// Respuesta
		return response()->json(["message" => "Post eliminado"], 200);
	}
}
