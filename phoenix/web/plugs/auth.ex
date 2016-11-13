defmodule Blogmvc.Plugs.Auth do
  import Plug.Conn
  import Phoenix.Controller, only: [redirect: 2]

  def init(_default) do
    
  end

  def call(conn, _default) do
    IO.inspect(get_session(conn, :auth))
    case get_session(conn, :auth) do
      %{id: id} -> 
        conn
      _ -> 
        conn 
          |> redirect(to: Blogmvc.Router.Helpers.user_path(conn, :login)) 
          |> halt
    end
  end

end
