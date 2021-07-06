create database transporteslamatanza;
use transporteslamatanza;

create table TipoUsuario(
id int auto_increment,
rol varchar (50),
primary key(id)
);

create table Usuario(
id int auto_increment,
nombre varchar (50),
apellido varchar(50),
legajo int,
dni int,
fecha_nacimiento date,
tipo_licencia varchar(50),
id_tipoUsuario int,
email varchar(50),
contraseña varchar(50),
cuenta_activada boolean,
primary key (id),
foreign key(id_tipoUsuario) references TipoUsuario(id)
);

create table TipoVehiculo(
id int auto_increment,
tipo_vehiculo varchar(50),
primary key(id)
);

create table Arrastre(
id int auto_increment,
patente varchar(40),
numeroDeChasis int,
tipo varchar(50),
peso_Neto float not null,
hazard boolean not null,
reefer boolean not null,
temperatura DECIMAL(5,2),
primary key(id)
);

create table Vehiculo(
id int auto_increment,
patente varchar(20),
numero_chasis int,
numero_motor int,
marca varchar(50),
modelo varchar(50),
año_Fabricacion date,
kilometraje int,
estado varchar(50),
alarma varchar(50),
id_tipoVehiculo int,
primary key (id),
foreign key (id_tipoVehiculo) references TipoVehiculo(id)
);

create table services(
id int auto_increment,
fecha varchar(50),
kilometros_unidad int,
costo double,
repuestos varchar(50),
id_vehiculo int,
id_usuario int,
primary key (id),
foreign key (id_vehiculo) references Vehiculo(id),
foreign key (id_usuario) references Usuario(id)
);

create table cliente(
    id int auto_increment,
    nombre varchar(50),
    apellido varchar(50),
    primary key(id)
);

create table Viaje(
id int auto_increment,
ciudad_origen varchar(50),
ciudad_destino varchar(50),
latitud_inicio double,
longitud_inicio double,
latitud_final double,
longitud_final double,
fecha_inicio date,
fecha_inicioReal date,
hora_inicio time,
fecha_fin date,
fecha_finReal date,
hora_fin time,
tiempo_estimado varchar(50),
tiempo_real varchar(50),
km_previsto double,
km_reales double,
descripcion_carga varchar(50),
desviacion double,
combustible_estimado double,
precioCombustible_estimado double,
precioViaticos_estimado double,
precioPeajes_estimado double,
precioExtras_estimado double,
precioFee_estimado double,
precioHazard_estimado double,
precioReefer_estimado double,
precioTotal_estimado double,
precioExtras_real double,
precioViaticos_Real double,
precioPeajes_Real double,
combustible_real double,
precioCombustible_real double,
costoTotalCombustible_real double,
precioTotal_real double,
viaje_enCurso boolean,
id_arrastre int,
id_vehiculo int,
id_usuario int,
primary key(id),
foreign key(id_vehiculo) references Vehiculo(id),
foreign key(id_arrastre) references Arrastre(id),
foreign key(id_usuario) references Usuario(id)
);

create table Factura(
    id int auto_increment,
    fecha date,
    monto double,
    abonado boolean,
    descripcion varchar(100),
    id_cliente int,
    id_viaje int,
    primary key(id),
    foreign key(id_viaje) references Viaje(id),
    foreign key(id_cliente) references Cliente(id)
);

create table ProformaChofer(
id_notificacion int not null auto_increment,
fecha_Inicio date,
latitud_actual varchar(50),
longitud_actual varchar(50),
combustible_actual double,
precioCombustible_actual double,
km_actuales double,
desviacion_actual double,
precioViaticos_actual double,
precioPeajes_actual double,
precioExtras_actual double,
fechaHoraPuntoControl datetime,
id_viaje int,
primary key(id_notificacion),
foreign key(id_viaje) references Viaje(id)
);

insert into TipoUsuario(id, rol)
values(1, "administrador"), (2, "gerente"), (3, "chofer"), (4, "mecanico");

insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, tipo_licencia ,id_tipoUsuario, email, contraseña, cuenta_activada)
values(1, "admin", "admin", 1, 42225, '99/01/01',"A" , 1, "admin@gmail.com", "1234", true);

insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, tipo_licencia ,id_tipoUsuario, email, contraseña, cuenta_activada)
values(2, "gerente", "gerente", 2, 11222333, '99/01/01',"A" , 2, "gerente@gmail.com", "1234", true);

insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, tipo_licencia ,id_tipoUsuario, email, contraseña, cuenta_activada)
values(3, "chofer", "chofer", 2, 22333444, '99/01/01',"A" , 3, "chofer@gmail.com", "1234", true);

insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, tipo_licencia ,id_tipoUsuario, email, contraseña, cuenta_activada)
values(4, "mecanico", "mecanico", 2, 33444555, '99/01/01',"A" , 4, "mecanico@gmail.com", "1234", true);

/* usuarios sin rol*/

insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, email, contraseña, cuenta_activada)
values(9, "tomas", "lala", 2, 89878625, "89-05-02","to@gmail.com", "1234", true),
		/*insert(3, "matias", "maradona", 3, 855578625, "89-05-02","matiasmaradona@gmail.com", "1234"),
        (4, "ana", "poooo", 4, 89878625, "89-05-02","tomaslala@gmail.com", "1234"),
        (5, "hola", "lk", 5, 89878625, "89-05-02","tomaslala@gmail.com", "1234"),*/
        (6, "taza", "jjj", 6, 89878625, "89-05-02","tom@gmail.com", "1234", true),
        (7, "equipo", "iiii", 7, 89878625, "89-05-02","t@gmail.com", "1234", true),
        (8, "ventana", "tttt", 8, 89878625, "89-05-02","tomasla@gmail.com", "1234", true);

insert into Usuario(id, nombre, apellido, legajo, dni, fecha_nacimiento, tipo_licencia ,id_tipoUsuario, email, contraseña, cuenta_activada)
values(5, "cho2", "chofer2", 4, 44, '99/01/01',"A" , 3, "chofer2@gmail.com", "1234", true);


insert into TipoVehiculo(id,tipo_vehiculo)
values(1,"Camioneta"),
	(2,"Camion"),
    (3,"Moto"),
    (4,"Auto");

insert into Vehiculo(id,patente,numero_chasis ,numero_motor ,marca,modelo,kilometraje ,estado,alarma,id_tipoVehiculo)
			  values(1,"ABC123",111,44444,"Ford","KA",90000,"usado","ring ring",4),
					(2,"ABC22",22,22,"Ford","dos",2222,"usado","ring ring",3);
                    



insert into Viaje(
id,ciudad_origen ,ciudad_destino,fecha_inicio,
fecha_fin ,tiempo_estimado , km_previsto , descripcion_carga,
combustible_estimado ,precioCombustible_estimado ,
precioViaticos_estimado ,precioPeajes_estimado ,precioExtras_estimado,
precioFee_estimado,precioHazard_estimado,precioReefer_estimado,
precioTotal_estimado,viaje_enCurso,id_vehiculo,id_usuario)
values(1, "cordoba", "tucuman",'21/05/03','21/06/03',10,2000,"pescado",8000,100,5000,4000,2000,1,1,1,11111,false,1,3),
	(2, "lima", "chile",'21/05/03','21/06/03',10,2000,"pescado",8000,100,5000,4000,2000,1,1,1,11111,false,2,5);
    


/*select * from Viaje;
select * from Vehiculo;
select * from Usuario WHERE id_tipoUsuario = '3';
select * from Usuario;

select *
from Viaje inner join TipoVehiculo ON Viaje.id_vehiculo = TipoVehiculo.id
WHERE id_usuario = '3' and viaje_enCurso = 1;

select * from ProformaChofer;

select  sum(combustible_actual),sum(precioPeajes_actual)
from ProformaChofer
where id_viaje=1;

select  sum(combustible_actual)as 'Costo Combustible', sum(precioPeajes_actual )as 'Total Peaje',sum(precioViaticos_actual)as 'Total Viaticos'
from ProformaChofer
where id_viaje=1;

select * from ProformaChofer;


SELECT 
sum((combustible_actual*precioCombustible_actual)) as totalCombustible,
sum(precioPeajes_actual )as 'TotalPeaje',
sum(precioViaticos_actual)as 'TotalViaticos',
sum(precioExtras_actual)as 'TotalExtras',
sum(combustible_actual) as 'cantidadDeCombustible',
avg(precioCombustible_actual) as 'promedioPrecioCombustible'
from ProformaChofer
where id_viaje='1';

UPDATE `transporteslamatanza`.`Viaje`
                SET `precioExtras_real` = '10', 
                    `precioViaticos_Real` = '5', 
                    `precioPeajes_Real` = ' 4', 
                    `combustible_real` = '6', 
                    `precioCombustible_real` = '2', 
                    `costoTotalCombustible_real` = '4' 
                WHERE (`id` = '1');*/