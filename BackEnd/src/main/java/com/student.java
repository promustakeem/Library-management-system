package com;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.Id;
import jakarta.persistence.Table;
import lombok.Data;

@Entity
@Data

@Table(name="stud")
public class student {
    @Id
    @Column(name = "ID")
    private int id;
    @Column(name = "marks")

    private int marks;
    @Column(name = "name")

    private  String name;

}
