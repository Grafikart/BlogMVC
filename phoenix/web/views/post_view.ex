defmodule Blogmvc.PostView do
  use Blogmvc.Web, :view
  import Scrivener.HTML

  def truncate(content, length, leading \\ "...") do
    words = String.split(content)
    if length(words) > length do
      words
        |> Enum.slice(0..length)
        |> Enum.join(" ")
        |> Kernel.<> leading
    else
      content
    end
  end

end
