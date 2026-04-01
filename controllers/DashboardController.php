<?php
/**
 * Controller do Dashboard
 */

class DashboardController {
    private $clienteModel;
    private $veiculoModel;
    private $projetoModel;
    
    public function __construct() {
        $this->clienteModel = new Cliente();
        $this->veiculoModel = new Veiculo();
        $this->projetoModel = new Projeto();
    }
    
    /**
     * Página principal do dashboard
     */
    public function index() {
        requireAuth();
        
        // Buscar estatísticas
        $stats = $this->projetoModel->getDashboardStats();
        
        // Buscar totais
        $stats['total_clientes'] = $this->clienteModel->countAll();
        $stats['total_veiculos'] = $this->veiculoModel->countAll();
        $stats['aniversariantes_mes'] = $this->clienteModel->countAniversariantes();
        
        // Buscar projetos recentes
        $projetosRecentes = $this->projetoModel->findAll(1, 10);
        
        // Buscar aniversariantes do mês
        $aniversariantes = $this->clienteModel->findAniversariantes();
        
        $data = [
            'stats' => $stats,
            'projetosRecentes' => $projetosRecentes,
            'aniversariantes' => $aniversariantes
        ];
        
        loadView('dashboard/index', $data);
    }
}