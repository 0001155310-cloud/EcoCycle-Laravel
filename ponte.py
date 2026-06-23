import serial
import requests
import time

# Altere para a porta correta do seu Arduino (COM3, COM4, /dev/ttyUSB0, etc.)
porta_serial = 'COM3' 
url_api = 'http://seu-dominio.com/api/arduino/store' # Ou sua rota local do Laravel

try:
    arduino = serial.Serial(porta_serial, 9600, timeout=1)
    print("Conectado ao Arduino com sucesso!")
except Exception as e:
    print(f"Erro ao conectar na porta {porta_serial}: {e}")
    exit()

while True:
    try:
        if arduino.in_waiting > 0:
            linha = arduino.readline().decode('utf-8').strip()
            
            # Divide os dados pela vírgula
            dados = linha.split(',')
            
            if len(dados) == 3:
                umidade = dados[0]
                temperatura = dados[1]
                gas = dados[2]
                
                # Monta o payload para o Laravel
                payload = {
                    "umidade": umidade,
                    "temperatura": temperatura,
                    "gas": gas,
                    "peso": 12.5, # Exemplo de valor fixo ou vindo de outra variável
                    "status_contaminacao": "ideal" if int(umidade) <= 40 else "atencao"
                }
                
                # Envia via POST para o Laravel
                response = requests.post(url_api, json=payload)
                print(f"Dados enviados: {payload} | Resposta: {response.status_code}")
                
    except Exception as e:
        print(f"Erro no loop de captura: {e}")
    
    time.sleep(1)