defmodule Blogmvc.Repo do
  use Ecto.Repo, otp_app: :blogmvc
  use Scrivener, page_size: 10
end
