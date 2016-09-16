package models;

import org.hibernate.annotations.Type;
import org.hibernate.validator.constraints.NotEmpty;
import org.joda.time.DateTime;
import play.db.jpa.JPA;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.ManyToOne;
import javax.persistence.OneToMany;
import java.util.List;

/**
 * Created by greg on 16/09/2016.
 */

@Entity
public class Posts {

  @Id
  @GeneratedValue(strategy = GenerationType.TABLE)
  public Long id;
  @ManyToOne
  public Categories categories;
  @ManyToOne
  public Users user;
  @OneToMany
  public List<Comments> associatedComments;

  @NotEmpty
  public String name;
  public String slug;
  @Column(columnDefinition="TEXT")
  public String contents;
  @Type(type = "org.jadira.usertype.dateandtime.joda.PersistentDateTime")
  public DateTime created;

  public static List<Posts> findAll() {
    return JPA.em().createQuery("SELECT p FROM Posts p ORDER BY p.created DESC", Posts.class).getResultList();
  }

  public static List<Posts> findFivePost() {
    return JPA.em().createQuery("SELECT p FROM Posts p ORDER BY p.created DESC", Posts.class).getResultList();
  }

  public static List<Posts> findFivePostFrom(Integer startPosition) {
    return JPA.em().createQuery("SELECT p FROM Posts p ORDER BY p.created DESC", Posts.class).setFirstResult(startPosition).getResultList();
  }


}
