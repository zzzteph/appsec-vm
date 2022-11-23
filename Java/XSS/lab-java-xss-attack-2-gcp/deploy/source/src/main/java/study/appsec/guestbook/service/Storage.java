package study.appsec.guestbook.service;

import study.appsec.guestbook.model.Comment;

import java.util.List;

public interface Storage {

    void add(Comment comment);

    List<Comment> listLast(int limit);

}
