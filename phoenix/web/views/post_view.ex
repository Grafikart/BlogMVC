defmodule Blogmvc.PostView do
  use Blogmvc.Web, :view

  def truncate(content, length, leading \\ "...") do
    words = content
      |> HtmlSanitizeEx.strip_tags
      |> String.split
    if length(words) > length do
      words
        |> Enum.slice(0..length)
        |> Enum.join(" ")
        |> Kernel.<>(leading)
    else
      content
    end
  end

  def markdown(content) do
    Earmark.to_html(content)
  end

end