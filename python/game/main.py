import sys
import numpy as np
player1 = 0
player2 = 0
p1 = []
p2 = []

#Read file
filename = "scores.txt"
try:
    with open(filename) as f:
        content = f.read().splitlines()
except:
    print("Error al leer el archivo")
    sys.exit()

content = list(filter(None, content))

limit = content.pop(0)

if not limit.isnumeric():
    print("El número de rondas no es numérico")
    sys.exit()

limit = int(limit)

if len(content) > 10000:
    print("El número de rondas debe ser menor o igual a 10000")
    sys.exit()

if len(content) != limit:
    print("El número de rondas en el archivo y el límite establecido no coinciden")
    sys.exit()


score = []
for i,line in enumerate(content, start=1):
    score.append(line.split())

for p in score:
    player1 += int(p[0])
    player2 += int(p[1])
    result = abs(player1 - player2)
    if player1 > player2:
        p1.append(result)
    elif player1 < player2:
        p2.append(result)

#Result
if len(p1) or len(p2):
    if np.sum(p1) > np.sum(p2):
        print("1 ", max(p1))
    else:
        print("2 ", max(p2))
else:
    print("Por favor revisa la información ingresada ya que no puede haber empate")
