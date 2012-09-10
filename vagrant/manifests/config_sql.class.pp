class config_sql
{

  exec
  {
    'mysql.open-port':
      path    => '/bin:/usr/bin',
      command => 'sudo /sbin/iptables -A INPUT -i eth0 -p tcp --destination-port 3306 -j ACCEPT'
  }
  
  file
  {
    'mysql.config':
      path    => '/etc/mysql/my.cnf',
      ensure  => present,
      source  => '/vagrant/vagrant/resources/app/etc/mysql/my.cnf'
  }

}
