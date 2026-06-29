import serial
import requests
import time
import json

# ================= CONFIGURAÇÃO DO SERVIDOR NO RENDER =================
URL_BASE = 'https://ecocycle-us8p.onrender.com'
URL_POST_LEITURA = f'{URL_BASE}/api/leituras'
URL_GET_CONFIG = f'{URL_BASE}/api/arduino/config-porta'
DISPOSITIVO_ID = 'arduino_01'
# ======================================================================

porta_atual = None
arduino = None

def conectar_serial(porta):
    print(f"Tentando conectar fisicamente à porta: {porta}...")
    try:
        conexao = serial.Serial(porta, 9600, timeout=1)
        time.sleep(2)  # Tempo para o Arduino reiniciar após o handshake
        print(f"Conectado com sucesso à porta {porta}!")
        return conexao
    except Exception as e:
        print(f"Aviso: Porta {porta} não encontrada ou ocupada. Erro: {e}")
        return None

print("Iniciando a Ponte EcoCycle (Comunicação Nuvem <-> Local)...")

while True:
    try:
        # 1. Pergunta ao Laravel no Render qual porta o Admin escolheu na Web
        try:
            res_config = requests.get(URL_GET_CONFIG, timeout=3)
            if res_config.status_code == 200:
                porta_selecionada_web = res_config.json().get('porta', 'COM3')
            else:
                porta_selecionada_web = 'COM3'
        except Exception as e:
            print(f"Erro ao conectar com o Render: {e}. Usando última porta conhecida.")
            porta_selecionada_web = porta_atual if porta_atual else 'COM3'

        # 2. Se o Admin mudou a porta na interface Web, reconecta localmente
        if porta_selecionada_web != porta_atual:
            print(f"\n[Alteração de Porta Detectada na Web] Mudando localmente de {porta_atual} para {porta_selecionada_web}")
            if arduino and arduino.is_open:
                arduino.close()
            porta_atual = porta_selecionada_web
            arduino = conectar_serial(porta_atual)

        # 3. Se a porta USB estiver aberta e houver dados do Arduino, envia para a Nuvem
        if arduino and arduino.in_waiting > 0:
            linha = arduino.readline().decode('utf-8').strip()
            
            if not linha or "Iniciando" in linha:
                continue
                
            print(f"Dados brutos da Serial ({porta_atual}): {linha}")
            dados = linha.split(',')
            
            if len(dados) == 3:
                umidade_porcento = float(dados[0])
                temp_graus = float(dados[1])
                gas_ppm = float(dados[2])
                
                payload = {
                    "dispositivo_id": DISPOSITIVO_ID,
                    "porta_serial": porta_atual, # Informa ao banco qual porta gerou esse dado
                    "temperatura": temp_graus,
                    "umidade": umidade_porcento,
                    "gas": gas_ppm,
                    "ph": 7.0,
                    "peso": 0.0,
                    "origem_cliente": "painel_principal"
                }
                
                headers = {'Content-Type': 'application/json'}
                response = requests.post(URL_POST_LEITURA, data=json.dumps(payload), headers=headers, timeout=5)
                print(f"-> Enviado para o Render! Status: {response.status_code}")
                
    except Exception as e:
        print(f"Falha no loop principal: {e}")
        if arduino:
            try: arduino.close()
            except: pass
        arduino = None
        
    time.sleep(1) # Aguarda 1 segundo antes de checar novamente