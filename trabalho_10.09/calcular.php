<?php
    // Verifica se os dados foram enviados por POST
    $dadosEnviados = ($_SERVER['REQUEST_METHOD'] === 'POST') && !empty($_POST['nome']) && isset($_POST['ano']);

    if ($dadosEnviados) {
        $nome = trim((string) $_POST['nome']);
        $ano = (int) $_POST['ano'];
        $anoAtual = (int) date('Y');

        // Calcula a idade e o tempo percorrido
        $idade = $anoAtual - $ano;
        $dias = $idade * 365.25;
        $horas = $dias * 24;
        $minutos = $horas * 60;

        // Médias e expectativas
        $batimentosmedia = 75;
        $respiracoesmedia = 20;
        $expectativadevida = 90;

        // Batimentos e respirações já realizados
        $batimentos = $minutos * $batimentosmedia;
        $respiracoes = $minutos * $respiracoesmedia;

        // Totais estimados para a vida inteira (90 anos)
        $minutosExpectativa = $expectativadevida * 365.25 * 24 * 60;
        $expectativadebatimentos = $minutosExpectativa * $batimentosmedia;
        $expectativaderespiracoes = $minutosExpectativa * $respiracoesmedia;

        // Expectativa restante
        $expectativadevidarestante = $expectativadevida - $idade;
        $batimentosrestantes = $expectativadebatimentos - $batimentos;
        $respiracoesrestantes = $expectativaderespiracoes - $respiracoes;

        $ultrapassouExpectativa = ($idade >= $expectativadevida);
        $horaextra = "Você ultrapassou a expectativa de vida!";

        // Formatações
        $nomeFormatado = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
        $primeiraLetra = mb_strtoupper(mb_substr($nome, 0, 1, 'UTF-8'), 'UTF-8');
        $diasFormatados = number_format($dias, 0, ',', '.');
        $horasFormatadas = number_format($horas, 0, ',', '.');
        $minutosFormatados = number_format($minutos, 0, ',', '.');
        $batimentosFormatados = number_format($batimentos, 0, ',', '.');
        $respiracoesFormatadas = number_format($respiracoes, 0, ',', '.');

        // Percentual percorrido para barra de progresso
        $porcentagemProgresso = min(100, max(0, round(($idade / $expectativadevida) * 100, 1)));

        if (!$ultrapassouExpectativa) {
            $anosRestantesFormatados = number_format($expectativadevidarestante, 0, ',', '.');
            $batimentosRestantesFormatados = number_format($batimentosrestantes, 0, ',', '.');
            $respiracoesRestantesFormatadas = number_format($respiracoesrestantes, 0, ',', '.');
        } else {
            $expectativadevidarestante = $horaextra;
            $batimentosrestantes = $horaextra;
            $respiracoesrestantes = $horaextra;
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Biométrico | <?= $dadosEnviados ? $nomeFormatado : 'Resultado' ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg-deep: #06080e;
            --bg-card: rgba(15, 23, 42, 0.8);
            --bg-surface: rgba(30, 41, 59, 0.45);
            --border-subtle: rgba(255, 255, 255, 0.08);
            --border-glow: rgba(56, 189, 248, 0.3);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --cyan: #06b6d4;
            --sky: #38bdf8;
            --blue: #3b82f6;
            --purple: #a855f7;
            --rose: #f43f5e;
            --emerald: #10b981;
            --amber: #f59e0b;
        }

        body {
            background-color: var(--bg-deep);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.25rem;
            color: var(--text-primary);
            position: relative;
            overflow-x: hidden;
        }

        /* Efeitos luminosos de fundo */
        .ambient-glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(130px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.4;
        }

        .glow-top-left {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #1e40af 0%, #0369a1 70%);
            top: -150px;
            left: -150px;
        }

        .glow-bottom-right {
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, #7e22ce 0%, #4c1d95 70%);
            bottom: -150px;
            right: -150px;
        }

        .glow-center {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #0e7490 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.2;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 720px;
        }

        /* Card Principal */
        .dashboard-card {
            background: var(--bg-card);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 28px;
            border: 1px solid var(--border-subtle);
            box-shadow: 
                0 30px 60px -15px rgba(0, 0, 0, 0.8),
                0 0 0 1px rgba(255, 255, 255, 0.04),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.15);
            padding: 2.5rem 2.25rem;
            position: relative;
            animation: fadeIn 0.45s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Topo: Perfil e Status */
        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.25rem;
            padding-bottom: 1.75rem;
            border-bottom: 1px solid var(--border-subtle);
            margin-bottom: 2rem;
        }

        .profile-user {
            display: flex;
            align-items: center;
            gap: 1.15rem;
        }

        .avatar-badge {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            background: linear-gradient(135deg, #0284c7 0%, #6366f1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Outfit', sans-serif;
            font-size: 1.65rem;
            font-weight: 800;
            color: #ffffff;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.35);
            border: 2px solid rgba(255, 255, 255, 0.2);
            flex-shrink: 0;
        }

        .user-meta h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.55rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .user-meta p {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-top: 0.2rem;
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.4rem 0.85rem;
            border-radius: 9999px;
            background: rgba(16, 185, 129, 0.1);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.25);
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.15);
        }

        .status-pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10b981;
            box-shadow: 0 0 8px #10b981;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.85); }
            100% { opacity: 1; transform: scale(1); }
        }

        /* Títulos de Seção */
        .section-tag {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--sky);
            margin-top: 1.75rem;
            margin-bottom: 1rem;
        }

        .section-tag svg {
            width: 17px;
            height: 17px;
        }

        /* Grid de Estatísticas: Tempo Percorrido */
        .stats-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.85rem;
            margin-bottom: 1.5rem;
        }

        .metric-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: 18px;
            padding: 1.15rem 0.85rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .metric-card:hover {
            transform: translateY(-3px);
            border-color: rgba(56, 189, 248, 0.35);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5), 0 0 15px rgba(56, 189, 248, 0.1);
            background: rgba(30, 41, 59, 0.7);
        }

        .metric-card .icon-chip {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.65rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--sky);
        }

        .metric-card .icon-chip svg {
            width: 18px;
            height: 18px;
        }

        .metric-label {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 0.35rem;
        }

        .metric-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.1;
            letter-spacing: -0.02em;
        }

        .metric-unit {
            font-size: 0.72rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }

        /* Cartões de Sinais Vitais Acumulados */
        .vitals-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .vital-card {
            border-radius: 20px;
            padding: 1.4rem 1.25rem;
            position: relative;
            overflow: hidden;
            border: 1px solid transparent;
            transition: all 0.25s ease;
        }

        .vital-card:hover {
            transform: translateY(-2px);
        }

        /* Card Batimentos */
        .vital-heart {
            background: linear-gradient(145deg, rgba(244, 63, 94, 0.12) 0%, rgba(15, 23, 42, 0.7) 100%);
            border-color: rgba(244, 63, 94, 0.25);
            box-shadow: 0 10px 30px -10px rgba(244, 63, 94, 0.15);
        }

        .vital-heart:hover {
            border-color: rgba(244, 63, 94, 0.45);
            box-shadow: 0 12px 35px -8px rgba(244, 63, 94, 0.25);
        }

        /* Card Respirações */
        .vital-breath {
            background: linear-gradient(145deg, rgba(16, 185, 129, 0.12) 0%, rgba(15, 23, 42, 0.7) 100%);
            border-color: rgba(16, 185, 129, 0.25);
            box-shadow: 0 10px 30px -10px rgba(16, 185, 129, 0.15);
        }

        .vital-breath:hover {
            border-color: rgba(16, 185, 129, 0.45);
            box-shadow: 0 12px 35px -8px rgba(16, 185, 129, 0.25);
        }

        .vital-header {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 0.85rem;
        }

        .vital-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vital-heart .vital-icon {
            background: rgba(244, 63, 94, 0.18);
            color: #fb7185;
            box-shadow: 0 0 15px rgba(244, 63, 94, 0.25);
        }

        .vital-heart .vital-icon svg {
            width: 20px;
            height: 20px;
            animation: heartBeat 1.4s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
        }

        @keyframes heartBeat {
            0% { transform: scale(1); }
            14% { transform: scale(1.22); }
            28% { transform: scale(1); }
            42% { transform: scale(1.15); }
            70% { transform: scale(1); }
        }

        .vital-breath .vital-icon {
            background: rgba(16, 185, 129, 0.18);
            color: #34d399;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.25);
        }

        .vital-breath .vital-icon svg {
            width: 20px;
            height: 20px;
            animation: breathe 3s ease-in-out infinite;
        }

        @keyframes breathe {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.12); opacity: 1; }
        }

        .vital-title {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .vital-heart .vital-title { color: #fda4af; }
        .vital-breath .vital-title { color: #a7f3d0; }

        .vital-number {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.7rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.1;
            margin-bottom: 0.3rem;
            word-break: break-word;
        }

        .vital-footer {
            font-size: 0.74rem;
            color: var(--text-secondary);
        }

        /* Barra de Progresso Vital */
        .progress-container {
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: 18px;
            padding: 1.15rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.82rem;
            margin-bottom: 0.65rem;
        }

        .progress-title {
            color: var(--text-secondary);
            font-weight: 600;
        }

        .progress-percentage {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            color: var(--sky);
        }

        .progress-bar-bg {
            width: 100%;
            height: 10px;
            background: rgba(255, 255, 255, 0.07);
            border-radius: 9999px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 9999px;
            background: linear-gradient(90deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.6);
            transition: width 1s ease-out;
        }

        .progress-markers {
            display: flex;
            justify-content: space-between;
            margin-top: 0.4rem;
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        /* Cartões de Expectativa Restante */
        .stats-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.85rem;
            margin-bottom: 1.75rem;
        }

        .future-card {
            background: linear-gradient(145deg, rgba(139, 92, 246, 0.12) 0%, rgba(15, 23, 42, 0.65) 100%);
            border: 1px solid rgba(139, 92, 246, 0.25);
            border-radius: 18px;
            padding: 1.15rem 0.85rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.25s ease;
        }

        .future-card:hover {
            transform: translateY(-3px);
            border-color: rgba(168, 85, 247, 0.45);
            box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.25);
        }

        .future-card .future-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #d8b4fe;
            margin-bottom: 0.35rem;
        }

        .future-card .future-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.15;
            word-break: break-word;
        }

        .future-card .future-unit {
            font-size: 0.72rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }

        /* Banner de Expectativa Ultrapassada (Conquista Épica) */
        .banner-overdue {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.25) 100%);
            border: 1px solid rgba(245, 158, 11, 0.45);
            box-shadow: 0 10px 30px -5px rgba(245, 158, 11, 0.2);
            border-radius: 20px;
            padding: 1.35rem 1.5rem;
            margin-bottom: 1.75rem;
            display: flex;
            align-items: center;
            gap: 1.15rem;
        }

        .banner-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(245, 158, 11, 0.25);
            border: 1px solid rgba(245, 158, 11, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fbbf24;
            flex-shrink: 0;
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.3);
        }

        .banner-icon svg {
            width: 26px;
            height: 26px;
        }

        .banner-overdue-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: #fef08a;
            margin-bottom: 0.25rem;
        }

        .banner-overdue-desc {
            font-size: 0.85rem;
            color: #fde68a;
            line-height: 1.4;
        }

        /* Tabela de Parâmetros Técnicos */
        .params-sheet {
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid var(--border-subtle);
            border-radius: 16px;
            padding: 0.9rem 1.25rem;
            margin-bottom: 1.85rem;
        }

        .param-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.82rem;
            padding: 0.35rem 0;
        }

        .param-row:not(:last-child) {
            border-bottom: 1px dashed rgba(255, 255, 255, 0.07);
        }

        .param-row .p-label {
            color: var(--text-muted);
        }

        .param-row .p-val {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* Botão Voltar */
        .btn-return {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            width: 100%;
            padding: 0.95rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: #ffffff;
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 60%, #4f46e5 100%);
            border: none;
            border-radius: 16px;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-return:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .btn-return:active {
            transform: scale(0.98);
        }

        .btn-return svg {
            width: 18px;
            height: 18px;
            transition: transform 0.2s;
        }

        .btn-return:hover svg {
            transform: translateX(-3px);
        }

        /* Estado Vazio */
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
        }

        .empty-badge {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: rgba(244, 63, 94, 0.15);
            border: 1px solid rgba(244, 63, 94, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #f43f5e;
            margin-bottom: 1.25rem;
            box-shadow: 0 0 20px rgba(244, 63, 94, 0.2);
        }

        .empty-badge svg {
            width: 34px;
            height: 34px;
        }

        .empty-state h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            color: #ffffff;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-secondary);
            font-size: 0.92rem;
            margin-bottom: 1.75rem;
        }

        /* Responsividade */
        @media (max-width: 650px) {
            .dashboard-card {
                padding: 1.85rem 1.25rem;
                border-radius: 22px;
            }
            .stats-grid-4 {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.65rem;
            }
            .vitals-grid {
                grid-template-columns: 1fr;
            }
            .stats-grid-3 {
                grid-template-columns: 1fr;
            }
            .profile-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <!-- Efeitos ambientais de iluminação escura -->
    <div class="ambient-glow glow-top-left"></div>
    <div class="ambient-glow glow-bottom-right"></div>
    <div class="ambient-glow glow-center"></div>

    <div class="container">
        <main class="dashboard-card">
            <?php if ($dadosEnviados): ?>
                <!-- Cabeçalho do Perfil -->
                <header class="profile-header">
                    <div class="profile-user">
                        <div class="avatar-badge">
                            <?= $primeiraLetra ?>
                        </div>
                        <div class="user-meta">
                            <h1><?= $nomeFormatado ?></h1>
                            <p>Nascido em <?= $ano ?> &bull; <?= $idade ?> <?= $idade === 1 ? 'ano' : 'anos' ?> de história</p>
                        </div>
                    </div>
                    <div class="status-chip">
                        <span class="status-pulse"></span>
                        <span>Vital Ativo</span>
                    </div>
                </header>

                <!-- Seção 1: Tempo Percorrido -->
                <div class="section-tag">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3"></path>
                    </svg>
                    <span>Tempo Percorrido</span>
                </div>

                <div class="stats-grid-4">
                    <div class="metric-card">
                        <div class="icon-chip">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="metric-label">Idade Atual</span>
                        <span class="metric-value"><?= $idade ?></span>
                        <span class="metric-unit"><?= $idade === 1 ? 'ano' : 'anos' ?></span>
                    </div>

                    <div class="metric-card">
                        <div class="icon-chip">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="metric-label">Dias</span>
                        <span class="metric-value"><?= $diasFormatados ?></span>
                        <span class="metric-unit">dias aprox.</span>
                    </div>

                    <div class="metric-card">
                        <div class="icon-chip">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"></path>
                            </svg>
                        </div>
                        <span class="metric-label">Horas</span>
                        <span class="metric-value"><?= $horasFormatadas ?></span>
                        <span class="metric-unit">horas aprox.</span>
                    </div>

                    <div class="metric-card">
                        <div class="icon-chip">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="metric-label">Minutos</span>
                        <span class="metric-value"><?= $minutosFormatados ?></span>
                        <span class="metric-unit">minutos aprox.</span>
                    </div>
                </div>

                <!-- Seção 2: Sinais Vitais Acumulados -->
                <div class="section-tag">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span>Sinais Vitais Já Realizados</span>
                </div>

                <div class="vitals-grid">
                    <div class="vital-card vital-heart">
                        <div class="vital-header">
                            <div class="vital-icon">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </div>
                            <span class="vital-title">Batimentos Cardíacos</span>
                        </div>
                        <div class="vital-number"><?= $batimentosFormatados ?></div>
                        <div class="vital-footer">Pulsos registrados na média de ~75 bpm</div>
                    </div>

                    <div class="vital-card vital-breath">
                        <div class="vital-header">
                            <div class="vital-icon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path>
                                </svg>
                            </div>
                            <span class="vital-title">Ciclos Respiratórios</span>
                        </div>
                        <div class="vital-number"><?= $respiracoesFormatadas ?></div>
                        <div class="vital-footer">Respirações completas na média de ~20 rpm</div>
                    </div>
                </div>

                <!-- Barra de Progresso Temporal da Vida -->
                <div class="progress-container">
                    <div class="progress-header">
                        <span class="progress-title">Jornada até a Expectativa de <?= $expectativadevida ?> Anos</span>
                        <span class="progress-percentage"><?= $porcentagemProgresso ?>%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: <?= $porcentagemProgresso ?>%;"></div>
                    </div>
                    <div class="progress-markers">
                        <span>0 anos</span>
                        <span>45 anos</span>
                        <span><?= $expectativadevida ?> anos</span>
                    </div>
                </div>

                <!-- Seção 3: Expectativa de Vida Restante -->
                <div class="section-tag">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Expectativa Restante (Base: <?= $expectativadevida ?> anos)</span>
                </div>

                <?php if ($ultrapassouExpectativa): ?>
                    <div class="banner-overdue">
                        <div class="banner-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="banner-overdue-title">&#10024; <?= $horaextra ?></div>
                            <div class="banner-overdue-desc">Você alcançou e superou a marca dos 90 anos de idade. Cada novo nascer do sol é uma conquista memorável de longevidade!</div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="stats-grid-3">
                        <div class="future-card">
                            <span class="future-label">Anos Restantes</span>
                            <span class="future-value"><?= $anosRestantesFormatados ?></span>
                            <span class="future-unit">anos estimados</span>
                        </div>

                        <div class="future-card">
                            <span class="future-label">Batimentos Previstos</span>
                            <span class="future-value"><?= $batimentosRestantesFormatados ?></span>
                            <span class="future-unit">pulsos futuros (~75 bpm)</span>
                        </div>

                        <div class="future-card">
                            <span class="future-label">Respirações Previstas</span>
                            <span class="future-value"><?= $respiracoesRestantesFormatadas ?></span>
                            <span class="future-unit">ciclos futuros (~20 rpm)</span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Parâmetros de Auditoria -->
                <div class="params-sheet">
                    <div class="param-row">
                        <span class="p-label">Identificação:</span>
                        <span class="p-val"><?= $nomeFormatado ?></span>
                    </div>
                    <div class="param-row">
                        <span class="p-label">Ano de Nascimento:</span>
                        <span class="p-val"><?= $ano ?></span>
                    </div>
                    <div class="param-row">
                        <span class="p-label">Ano Vigente de Referência:</span>
                        <span class="p-val"><?= $anoAtual ?></span>
                    </div>
                    <div class="param-row">
                        <span class="p-label">Parâmetro de Expectativa:</span>
                        <span class="p-val"><?= $expectativadevida ?> anos</span>
                    </div>
                </div>

                <a href="index.html" class="btn-return">
                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Novo Cálculo Biométrico</span>
                </a>

            <?php else: ?>
                <!-- Estado vazio caso acesse diretamente sem POST -->
                <div class="empty-state">
                    <div class="empty-badge">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h2>Nenhum Dado Recebido</h2>
                    <p>Para visualizar as métricas biológicas, preencha o formulário com seu nome e ano de nascimento.</p>
                    <a href="index.html" class="btn-return">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Ir para o Formulário</span>
                    </a>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>