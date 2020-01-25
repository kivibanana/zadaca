#!/usr/bin/python3
# -*- coding: utf-8 -*-

num_rows = int(input("Number of rows: "))
num_columns = int(input("Number of columns: "))

if num_rows == 0 or num_columns == 0:

    print("Incorrect input value!")

else:

    matrix = []

    num_elements = num_rows * num_columns

    row_idx = num_rows - 1
    column_idx = num_columns - 1

    row_counter = num_rows - 1
    column_counter = num_columns

    for i in range(num_rows):
        matrix.append([""] * num_columns)

    coordinate = (row_idx, column_idx)

    if num_columns == 1:

        for i in range(num_rows):
            if num_elements == 1:
                matrix[row_idx][column_idx] = [num_elements, ""]
            else:
                matrix[row_idx][column_idx] = [num_elements, "up"]
            num_elements -= 1
            row_idx -= 1

    elif num_rows == 1:

        for i in range(column_counter):
            if num_elements == 1:
                matrix[row_idx][column_idx] = [num_elements, ""]
            else:
                matrix[row_idx][column_idx] = [num_elements, "left"]
            num_elements -= 1
            column_idx -= 1

    else:

        while num_elements > 0:

            for i in range(column_counter):
                if num_elements == 1:
                    matrix[row_idx][column_idx] = [num_elements, ""]
                elif i < (column_counter - 1):
                    matrix[row_idx][column_idx] = [num_elements, "left"]
                else:
                    matrix[row_idx][column_idx] = [num_elements, "up"]
                num_elements -= 1
                column_idx -= 1

            if num_elements == 0:
                break

            column_idx += 1
            column_counter -= 1
            row_idx -= 1

            for i in range(row_counter):
                if num_elements == 1:
                    matrix[row_idx][column_idx] = [num_elements, ""]
                elif i < (row_counter - 1):
                    matrix[row_idx][column_idx] = [num_elements, "up"]
                else:
                    matrix[row_idx][column_idx] = [num_elements, "right"]
                num_elements -= 1
                row_idx -= 1

            if num_elements == 0:
                break

            row_idx += 1
            row_counter -= 1
            column_idx += 1

            for i in range(column_counter):
                if num_elements == 1:
                    matrix[row_idx][column_idx] = [num_elements, ""]
                elif i < (column_counter - 1):
                    matrix[row_idx][column_idx] = [num_elements, "right"]
                else:
                    matrix[row_idx][column_idx] = [num_elements, "down"]
                num_elements -= 1
                column_idx += 1

            if num_elements == 0:
                break

            column_idx -= 1
            column_counter -= 1
            row_idx += 1

            for i in range(row_counter):
                if num_elements == 1:
                    matrix[row_idx][column_idx] = [num_elements, ""]
                elif i < (row_counter - 1):
                    matrix[row_idx][column_idx] = [num_elements, "down"]
                else:
                    matrix[row_idx][column_idx] = [num_elements, "left"]
                num_elements -= 1
                if num_elements == 0:
                    break
                row_idx += 1

            if num_elements == 0:
                break

            row_idx -= 1
            row_counter -= 1
            column_idx -= 1

    print("\n")
    for i in matrix:
        for j in i:
            print(j, end="\t")
        print("\n")
