package com.backend.ssti.DAO;

import javax.persistence.*;

@Entity
@Table(name = "Blog")
public class Blog {

    @Id
    @GeneratedValue(strategy= GenerationType.IDENTITY)
    @Column(name="id")
    private int Id;

    private String name;

    private String message;

    public Blog(){

    }

    public Blog(String name, String message) {
        this.name = name;
        this.message = message;
    }

    public String getName() {
        return name;
    }

    public String getMessage() {
        return message;
    }
}
