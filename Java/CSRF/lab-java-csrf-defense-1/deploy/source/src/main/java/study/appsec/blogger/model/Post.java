package study.appsec.blogger.model;

import lombok.Getter;
import lombok.Setter;
import lombok.experimental.Accessors;
import org.hibernate.annotations.*;
import org.hibernate.annotations.Cache;
import org.hibernate.validator.constraints.Length;

import javax.persistence.*;
import javax.persistence.CascadeType;
import javax.persistence.Entity;
import javax.persistence.Table;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

@Setter
@Getter
@Accessors(chain = true)

@Entity
@Table(name = "`post`")
@Cache(usage = CacheConcurrencyStrategy.READ_WRITE)
public class Post extends BaseModel {

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "`user_id`")
    private User user;

    @Column
    @Length(min = 20, max = 255)
    private String title;

    @Column
    @Length(min = 100, max = 10000)
    private String text;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "`date_created`")
    private Date dateCreated;

    @Temporal(TemporalType.TIMESTAMP)
    @Column(name = "`date_updated`")
    private Date dateUpdated;

    @OneToMany(cascade = CascadeType.ALL, orphanRemoval = true)
    @JoinColumn(name = "`post_id`")
    private List<Comment> comments = new ArrayList<>();

    @Transient
    private int rating;

}
