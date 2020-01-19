#!/usr/bin/python3
# -*- coding: utf-8 -*-

NUM_ROWS = int(input("Number of rows: "))
NUM_COLUMNS = int(input("Number of columns: "))
START_POINT = input(
    "Set start point (upper left, upper right, bottom left, bottom right) [ul/ur/bl/br]: "
)
ROT_DIR = input("Set rotation direction (clockwise, counterclockwise) [cw/cc]: ")

MATRIX = []
NUM_ELEMENTS = NUM_ROWS * NUM_COLUMNS

for i in range(NUM_ROWS):
    MATRIX.append([""] * NUM_COLUMNS)

START_POINTS = {
    "ul": (0, 0),
    "ur": (0, NUM_COLUMNS - 1),
    "bl": (NUM_ROWS - 1, 0),
    "br": (NUM_ROWS - 1, NUM_COLUMNS - 1),
}

COORD_START_POINT = START_POINTS[START_POINT]

ROUTE_CW = ("right", "down", "left", "up")
ROUTE_CC = ("down", "right", "up", "left")


def start_directions(start_point="br", rot_direction="cw"):

    if start_point == "ul" and rot_direction == "cw":
        start_direction = ROUTE_CW[0]

    elif start_point == "ur" and rot_direction == "cw":
        start_direction = ROUTE_CW[1]

    elif start_point == "br" and rot_direction == "cw":
        start_direction = ROUTE_CW[2]

    elif start_point == "bl" and rot_direction == "cw":
        start_direction = ROUTE_CW[3]

    elif start_point == "ul" and rot_direction == "cc":
        start_direction = ROUTE_CC[0]

    elif start_point == "bl" and rot_direction == "cc":
        start_direction = ROUTE_CC[1]

    elif start_point == "br" and rot_direction == "cc":
        start_direction = ROUTE_CC[2]

    else:  # if start_point == "ur" and rot_direction = "cc":
        start_direction = ROUTE_CC[3]

    if rot_direction == "cw":
        return start_direction, ROUTE_CW

    else:
        return start_direction, ROUTE_CC


def next_direction(current_direction):

    if ROUTE.index(current_direction) == 3:
        return ROUTE[0]

    else:
        return ROUTE[ROUTE.index(current_direction) + 1]


def write_element(coord):

    global NUM_ELEMENTS

    while NUM_ELEMENTS > 0:

        if DIRECTION == "left":
            left(coord)

        if DIRECTION == "right":
            right(coord)

        if DIRECTION == "down":
            down(coord)

        if DIRECTION == "up":
            up(coord)


def left(coord):

    global DIRECTION, NUM_ELEMENTS

    if (coord[1] - 1 > 0) and (MATRIX[coord[0]][coord[1] - 1] == ""):
        MATRIX[coord[0]][coord[1]] = [NUM_ELEMENTS, "left"]
        NUM_ELEMENTS -= 1
        coord = (coord[0], coord[1] - 1)
        left(coord)

    elif (coord[1] - 1) == 0 and (MATRIX[coord[0]][coord[1] - 1] == ""):
        MATRIX[coord[0]][coord[1]] = [NUM_ELEMENTS, "left"]
        NUM_ELEMENTS -= 1
        coord = (coord[0], coord[1] - 1)
        DIRECTION = next_direction("left")
        write_element(coord)

    elif NUM_ELEMENTS == 1:
        MATRIX[coord[0]][coord[1]] = [NUM_ELEMENTS, "left"]
        NUM_ELEMENTS -= 1

    else:
        DIRECTION = next_direction("left")
        write_element(coord)


def right(coord):

    global DIRECTION, NUM_ELEMENTS

    if (coord[1] + 1) < (NUM_COLUMNS - 1) and (MATRIX[coord[0]][coord[1] + 1] == ""):
        MATRIX[coord[0]][coord[1]] = [NUM_ELEMENTS, "right"]
        NUM_ELEMENTS -= 1
        coord = (coord[0], coord[1] + 1)
        right(coord)

    elif (coord[1] + 1) == (NUM_COLUMNS - 1) and (MATRIX[coord[0]][coord[1] + 1] == ""):
        MATRIX[coord[0]][coord[1]] = [NUM_ELEMENTS, "right"]
        NUM_ELEMENTS -= 1
        coord = (coord[0], coord[1] + 1)
        DIRECTION = next_direction("right")
        write_element(coord)

    elif NUM_ELEMENTS == 1:
        MATRIX[coord[0]][coord[1]] = [NUM_ELEMENTS, "right"]
        NUM_ELEMENTS -= 1

    else:
        DIRECTION = next_direction("right")
        write_element(coord)


def up(coord):

    global DIRECTION, NUM_ELEMENTS

    if (coord[0] - 1) > 0 and (MATRIX[coord[0] - 1][coord[1]] == ""):
        MATRIX[coord[0]][coord[1]] = [NUM_ELEMENTS, "up"]
        NUM_ELEMENTS -= 1
        coord = (coord[0] - 1, coord[1])
        up(coord)

    elif (coord[0] - 1) == 0 and (MATRIX[coord[0] - 1][coord[1]] == ""):
        MATRIX[coord[0]][coord[1]] = [NUM_ELEMENTS, "up"]
        NUM_ELEMENTS -= 1
        coord = (coord[0] - 1, coord[1])
        DIRECTION = next_direction("up")
        write_element(coord)

    elif NUM_ELEMENTS == 1:
        MATRIX[coord[0]][coord[1]] = [NUM_ELEMENTS, "up"]
        NUM_ELEMENTS -= 1

    else:
        DIRECTION = next_direction("up")
        write_element(coord)


def down(coord):

    global DIRECTION, NUM_ELEMENTS

    if (coord[0] + 1) < (NUM_ROWS - 1) and (MATRIX[coord[0] + 1][coord[1]] == ""):
        MATRIX[coord[0]][coord[1]] = [NUM_ELEMENTS, "down"]
        NUM_ELEMENTS -= 1
        coord = (coord[0] + 1, coord[1])
        down(coord)

    elif (coord[0] + 1) == (NUM_ROWS - 1) and (MATRIX[coord[0] + 1][coord[1]] == ""):
        MATRIX[coord[0]][coord[1]] = [NUM_ELEMENTS, "down"]
        NUM_ELEMENTS -= 1
        coord = (coord[0] + 1, coord[1])
        DIRECTION = next_direction("down")
        write_element(coord)

    elif NUM_ELEMENTS == 1:
        MATRIX[coord[0]][coord[1]] = [NUM_ELEMENTS, "down"]
        NUM_ELEMENTS -= 1

    else:
        DIRECTION = next_direction("down")
        write_element(coord)


DIRECTION, ROUTE = start_directions(START_POINT, ROT_DIR)

write_element(COORD_START_POINT)

print("\n")
for i in MATRIX:
    for j in i:
        print(j, end="\t")
    print("\n")
print("\n")
