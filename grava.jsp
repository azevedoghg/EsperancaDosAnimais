<%@page language="java" import="java.sql.*" %>

<%
    //cria as variaveis e armazena as informações digitadas pelo usuário
    String vnome  = request.getParameter("txtNome") ;
    int    vid_solicitacao = Integer.parseInt( request.getParameter("txtidSolicitacao") );
    String vemail = request.getParameter("txtEmail");
    String vendereco = request.getParameter("txtEndereço");
    String vtelefone = request.getParameter("txtTelefone");
    String vmoradia = request.getParameter("txtMoradia");
    String vmotivo = request.getParameter("txtMotivo");
    String vporteanimal = request.getParameter("txtPorte Animal");
    String vnomeanimal = request.getParameter("txtNome Animal");
    String vperfil_ig = request.getParameter("txtPerfil Instagram");
    int   vdata_nasc = Integer.parseInt( request.getParameter("txtData de Nascimento") );

    //variaveis para acessar o banco de dados
    String database = "web"; 
    String endereco = "jdbc:mysql://localhost:3306/" + database ; 
    String usuario  = "root"; 
    String senha    = "";

    //Driver 
    String driver = "com.mysql.jdbc.Driver" ;

    //Carrega o driver na memoria
    Class.forName( driver ) ;

    //Cria a variavel para conectar com o banco
    Connection conexao ;

   //Abrir a conexao com o banco
   conexao = DriverManager.getConnection( endereco , usuario, senha) ;

   //Varival para o comando Insert do SQL
   String sql = "INSERT INTO solicitacao_adocao (idSolicitacao, nome, dataNasc, instagram, email, telefone, endereco, moradia, motivo, porteAnimal, nomeAnimal) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" ;

   //Cria a variavel Statement para executar o SQL
   PreparedStatement stm = conexao.prepareStatement(sql) ;
   stm.setString( 1 , vnome ) ;
   stm.setInt( 2 , vid_solicitacao ) ;
   stm.setString( 3 , vemail ) ;
   stm.setString( 4 , vendereco ) ;
   stm.setString( 5 , vtelefone ) ;
   stm.setString( 6 , vmoradia ) ;
   stm.setString( 7 , vmotivo ) ;
   stm.setString( 8 , vporteanimal ) ;
   stm.setString( 9 , vnomeanimal ) ;
   stm.setString( 10 , vperfil_ig ) ;
   stm.setString( 11 , vdata_nasc ) ;

   stm.execute() ;
   stm.close() ;

   out.print("<h3>Dados gravados!</h3>") ;
   out.print("<br><br>") ;
   out.print("<a href='cadastro.html'>Voltar</a>") ;

%>