package models;

import helpers.TimeAgo;
import org.hibernate.annotations.Type;
import org.hibernate.validator.constraints.Email;
import org.hibernate.validator.constraints.NotEmpty;
import org.joda.time.DateTime;
import play.data.validation.Constraints;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.ManyToOne;

/**
 * Created by greg on 16/09/2016.
 */

@Entity
public class Comments {

  @Id
  @GeneratedValue(strategy = GenerationType.TABLE)
  public Long id;
  @ManyToOne
  public Posts post;
  @NotEmpty
  public String username;
  @NotEmpty
  @Email
  public String email;
  @NotEmpty
  @Column(columnDefinition="TEXT")
  public String content;
  @Type(type = "org.jadira.usertype.dateandtime.joda.PersistentDateTime")
  public DateTime created;

  public String toAgo() {
    return TimeAgo.toDuration((DateTime.now().getMillis() - this.created.getMillis()));
  }

  public static class CommentForm {
    @Constraints.Required
    @Email
    public String email;
    @Constraints.Required
    public String username;

    @Override
    public String toString() {
      return "CommentForm{" +
          "email='" + email + '\'' +
          ", username='" + username + '\'' +
          ", content='" + content + '\'' +
          '}';
    }

    @Constraints.Required
    public String content;

    public CommentForm() {
    }

    public CommentForm(String email, String username, String content) {
      this.email = email;
      this.username = username;
      this.content = content;
    }

    public Comments toComment(Posts post) {
      Comments comment = new Comments();
      comment.id = null;
      comment.content = this.content;
      comment.username = this.username;
      comment.email = this.email;
      comment.post = post;
      comment.created = DateTime.now();
      return comment;
    }

    public String getEmail() {
      return email;
    }

    public void setEmail(String email) {
      this.email = email;
    }

    public String getUsername() {
      return username;
    }

    public void setUsername(String username) {
      this.username = username;
    }

    public String getContent() {
      return content;
    }

    public void setContent(String content) {
      this.content = content;
    }
  }
}
