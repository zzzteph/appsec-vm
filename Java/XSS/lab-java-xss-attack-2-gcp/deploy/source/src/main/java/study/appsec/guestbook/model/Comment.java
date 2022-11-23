package study.appsec.guestbook.model;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.Setter;

@Setter
@Getter
@AllArgsConstructor
public class Comment {

    private String name;
    private String message;

}
