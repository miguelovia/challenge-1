import sys
import numpy as np
player1 = 0
player2 = 0
p1 = []
p2 = []

#Function write file
def write_file(output,data):
    try:
        with open(output, "w") as f:
            f.write(data)
    except:
        print("Error al escribir archivo")
        sys.exit()
    finally:
        f.close()

#Read file
if len(sys.argv) == 1:
    print("Debe especificar el nombre del archivo de entrada")
    sys.exit()

try:
    with open(sys.argv[1]) as f:
        content = f.read().splitlines()
except:
    print("Error al leer el archivo")
    sys.exit()
finally:
    f.close()

content = list(filter(None, content))

limit = content.pop(0)

if not limit.isnumeric():
    print("El número de rondas debe ser numérico")
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

try:
    for p in score:
        player1 += int(p[0])
        player2 += int(p[1])
        result = abs(player1 - player2)
        if player1 > player2:
            p1.append(result)
        elif player1 < player2:
            p2.append(result)
except:
    print("Error al procesar datos de la ronda")
    sys.exit()

#Result
if len(p1) or len(p2):
    outFile = "output.txt"
    if np.sum(p1) > np.sum(p2):
        write_file(outFile,"1 %i" % (max(p1)))
    else:
        write_file(outFile, "2 %i" % (max(p2)))
else:
    print("Por favor revisa la información ingresada ya que no puede haber empate")
