package models;

import org.hibernate.annotations.Type;
import org.hibernate.validator.constraints.NotEmpty;
import org.joda.time.DateTime;
import play.Logger;
import play.db.jpa.JPA;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.ManyToOne;
import javax.persistence.OneToMany;
import javax.persistence.OneToOne;
import java.util.ArrayList;
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
  @OneToOne
  public Slug slug;
  @Column(columnDefinition = "TEXT")
  public String contents;
  @Type(type = "org.jadira.usertype.dateandtime.joda.PersistentDateTime")
  public DateTime created;

  public Posts() {
    this.id = 0L;
    this.name = "";
    this.slug = null;
    this.contents = "";
  }

  public static Posts find(Long id) {
    try {
      return JPA.em().createQuery("SELECT p FROM Posts p WHERE p.id = :id", Posts.class)
          .setParameter("id", id)
          .getSingleResult();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return null;
    }
  }

  public static List<Posts> findAll() {
    try {
      return JPA.em().createQuery("SELECT p FROM Posts p ORDER BY p.created DESC", Posts.class).getResultList();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return new ArrayList<>();
    }
  }

  public static List<Posts> findFivePost() {
    try {
      return JPA.em().createQuery("SELECT p FROM Posts p ORDER BY p.created DESC", Posts.class).getResultList();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return new ArrayList<>();
    }
  }

  public static List<Posts> findFivePostFrom(Integer startPosition) {
    try {
      return JPA.em().createQuery("SELECT p FROM Posts p ORDER BY p.created DESC", Posts.class).setFirstResult(startPosition).getResultList();
    } catch (Exception e) {
      Logger.error(e.getMessage());
      return new ArrayList<>();
    }
  }


}
