package models;

import org.hibernate.annotations.Type;
import org.hibernate.validator.constraints.Email;
import org.hibernate.validator.constraints.NotEmpty;
import org.joda.time.DateTime;

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
}
