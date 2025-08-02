import React, { useCallback, useEffect, useState, useMemo   } from 'react';
import ReactFlow, {
    MiniMap,
    Controls,
    Background,
    useNodesState,
    useEdgesState,
    BaseEdge,
    EdgeLabelRenderer,
    getBezierPath,
    getStraightPath,
    getSmoothStepPath

} from 'reactflow';
import OrgChartNode from "./OrgchartNode.jsx"
import ColorPicker from "./ColorSelect ";
import { Tab } from '@headlessui/react';
import Modal from "./Modal";
import { dagreLayout } from '../dagreLayout';
import 'reactflow/dist/style.css';
import Select from 'react-select';
import DownloadButton from './Exportable';
import { ToastContainer, toast } from 'react-toastify';
import * as LucideIcons from 'lucide-react';

  const nodeTypes = {
        orgNode: (props) => <OrgChartNode {...props} id={props.id} />
    };

function OrgChart({ organigramaId }) {
    const [filter, setFilter] = useState('all');
    const [nodes, setNodes, onNodesChange] = useNodesState([]);
    const [edges, setEdges, onEdgesChange] = useEdgesState([]);
    const [allNodes, setAllNodes] = useState([]);
    const [allEdges, setAllEdges] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);
    const [mensaje, setMensaje] = useState({ texto: '', tipo: '' });
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [isModalOpenGroupMembers, setIsModalOpenGroupMembers] = useState(false);
    const [isModalOpenResponsabilities, setIsModalOpenResponsabilities] = useState(false);
    const [isEditing, setIsEditing] = useState(false);
    const [currentNode, setCurrentNode] = useState(null);
    const [integrantes, setIntegrantes] = useState([]);
    const [responsabilidades, setResponsabilidades] = useState([]);
    const [fichas, setFichas] = useState([]);
    const [useFicha, setUseFicha] = useState(false); // Toggle
    const [selectKey, setSelectKey] = useState(0);
    const snapGrid = [25, 25];
    const [isEditingGroupMember, setIsEditingGroupMember] = useState(false);
    const [isEditingResponsability, setIsEditingResponsability] = useState(false);

    const [currentIntegranteId, setCurrentIntegranteId] = useState(null);
    const [currentResponsabilityId, setCurrentResponsabilityId] = useState(null);

    const [selectedTabIndex, setSelectedTabIndex] = useState(0);
    const [selectedTabIndexResponsabilities, setSelectedTabIndexResponsabilities] = useState(0);


    const [formData, setFormData] = useState({
        id: '',
        title: '',
        subtitle: '',
        type: 'D',
        color: '#3b82f6',
        icon: '',
        x: 0,
        y: 0
    });

    const [formDataGroupMembers, setFormDataGroupMembers] = useState({
        nombre: '',
        puesto: '',
        ficha_id: null,
        useFicha: false,
        coordinador: false,
        orden: 0,
    });

    const [formDataResponsabilities, setFormDataResponsabilities] = useState({
        descripcion: '',
        orden: 0,
    });

    const openEditModal = (node) => {
        setCurrentNode(node);
        setFormData({
            id: node.data.id,
            title: node.data.title,
            subtitle: node.data.subtitle,
            type: node.data.type,
            color: node.data.color,
            icon: node.data.icon,
        });
        setIsModalOpen(true);
    };

    const openGroupMembersModal = (node) => {
        setCurrentNode(node);
        if (node) {
            fetch(`../../integrantes/index/${node.id}`)
                .then(res => res.json())
                .then(setIntegrantes);

            fetch('../../fichas/listado')
                .then(res => res.json())
                .then(setFichas);
        }
        setIsModalOpenGroupMembers(true);
        resetForm();
    }

    const openResponsabilitiesModal = (node) => {
        setCurrentNode(node);
        if (node) {
            fetch(`../../responsabilidades/index/${node.id}`)
                .then(res => res.json())
                .then(setResponsabilidades);
        }
        setIsModalOpenResponsabilities(true);
    }

    useEffect(() => {
        const handleEditNode = (event) => {
            const nodeId = event.detail;
            const nodeToEdit = nodes.find(node => node.id === nodeId);
                if (nodeToEdit) {
                    openEditModal(nodeToEdit);
                }
            };

            window.addEventListener('editNode', handleEditNode);

            return () => {
             window.removeEventListener('editNode', handleEditNode);
        };
    }, [nodes]);

    useEffect(() => {
        const handleEditGroupMembersNode = (event) => {
            const nodeId = event.detail;
            const nodeToEdit = nodes.find(node => node.id === nodeId);
                if (nodeToEdit) {
                    openGroupMembersModal(nodeToEdit);
                }
        };

        window.addEventListener('editGroupMembersNode', handleEditGroupMembersNode);

        return () => {
             window.removeEventListener('editGroupMembersNode', handleEditGroupMembersNode);
        };
    }, [nodes]);

    useEffect(() => {
        const handleEditResponsabilitiesNode = (event) => {
            const nodeId = event.detail;
            const nodeToEdit = nodes.find(node => node.id === nodeId);
                if (nodeToEdit) {
                    openResponsabilitiesModal(nodeToEdit);
                }
        };

        window.addEventListener('editResponsabilitiesNode', handleEditResponsabilitiesNode);

        return () => {
             window.removeEventListener('editResponsabilitiesNode', handleEditResponsabilitiesNode);
        };
    }, [nodes]);

    const handleFichaChange = (selectedOption) => {
        setFormDataGroupMembers({
            ...formDataGroupMembers,
            ficha_id: selectedOption ? selectedOption.value : ''
        });
    };

    const fichaOptions = fichas.map(ficha => ({
        value: ficha.NUMERO,
        label: `${ficha.NUMERO} - ${ficha.NOMBRE}`
    }));

    const fetchOrganigramaData = useCallback(async () => {
        try {
            setIsLoading(true);
            setError(null);

            const nodesResponse = await fetch(`../../nodos/index/${organigramaId}`);
            if (!nodesResponse.ok) throw new Error('Error al cargar nodos');
            const nodesData = await nodesResponse.json();

            const edgesResponse = await fetch(`../../conexiones/index/${organigramaId}`);
            if (!edgesResponse.ok) throw new Error('Error al cargar conexiones');
            const edgesData = await edgesResponse.json();

            const formattedNodes = nodesData.nodos.map(node => ({
                id: node.id.toString(),
                type: "orgNode",
                position: { x: node.x_pos || 0, y: node.y_pos || 0 },
                data: {
                    id: node.id,
                    title: node.titulo,
                    subtitle: node.subtitulo ?? '',
                    type: node.tipo,
                    color: node.color,
                    icon: node.icon,
                }
            }));

            const formattedEdges = edgesData.conexiones.map(edge => ({
                id: `${edge.id}`,
                source: edge.nodo_padre_id.toString(),
                target: edge.nodo_hijo_id.toString(),
                animated: edge.animated || false
            }));

            setAllNodes(formattedNodes);
            setAllEdges(formattedEdges);
            applyLayout(formattedNodes, formattedEdges);
        } catch (err) {
            setError(err.message);
            applyLayout(initialNodes, initialEdges);
        } finally {
            setIsLoading(false);
        }
    }, [organigramaId]);

    const initialNodes = [];
    const initialEdges = [];

    const applyFilter = useCallback((filterType, nodes = allNodes, edges = allEdges) => {
        let filteredNodes = nodes;
        let filteredEdges = edges;

        if (filterType === 'resumido') {
            filteredNodes = nodes.filter(node => node.data.type !== 'D');
            filteredEdges = edges.filter(edge =>
                filteredNodes.some(n => n.id === edge.source) &&
                filteredNodes.some(n => n.id === edge.target)
            );
        } else if (filterType === 'detallado') {
            filteredNodes = nodes.filter(node => node.data.type !== 'R');
            filteredEdges = edges.filter(edge =>
                filteredNodes.some(n => n.id === edge.source) &&
                filteredNodes.some(n => n.id === edge.target)
            );
        }

        applyLayout(filteredNodes, filteredEdges);
    }, [allNodes, allEdges]);

    const handleFilterChange = (newFilter) => {
        setFilter(newFilter);
        applyFilter(newFilter);
    };

    const applyLayout = useCallback((nodes, edges) => {
      /*const { nodes: layoutedNodes, edges: layoutedEdges } = dagreLayout(
        nodes,
        edges,
        'TB'
      );*/
      setNodes(nodes);
      setEdges(edges);
    }, [setNodes, setEdges]);

    useEffect(() => {
        fetchOrganigramaData();
    }, [fetchOrganigramaData]);

    const onConnect = useCallback(async (conexion) => {


        try {

            const response = await axios.post(`../../conexiones/store/${organigramaId}`, {
                        nodo_padre: conexion.source,
                        nodo_hijo: conexion.target,
                    });

            setEdges((eds) => [...eds, {
                id: response.data.id,
                source: conexion.source,
                target: conexion.target,
            }]);
        } catch (error) {
            console.log(error)
            toast.error(error.response.data.message, {
                ariaLabel: "something"
            })
        }


        /*try {
            const response = await fetch(`../../conexiones/store/${organigramaId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    nodo_padre: conexion.source,
                    nodo_hijo: conexion.target,
                })
            });

            if (!response.ok) {
                console.log(response)
                toast.error(response.message, {
                    ariaLabel: "something"
                })
                throw error;
            }

            const data = await response.json();

            setEdges((eds) => [...eds, {
                id: data.id,
                source: conexion.source,
                target: conexion.target,
            }]);

            return data.id;
        } catch (error) {
            console.log('aqui')
            toast.error(error.message, {
                ariaLabel: "something"
            })
            throw error;
        }*/
    }, []);

    const CustomEdge = ({
        id,
        sourceX,
        sourceY,
        targetX,
        targetY,
        sourcePosition,
        targetPosition,
        style = {strokeWidth: 3},
        markerEnd,
        onEdgeDelete
    }) => {
        const [edgePath, labelX, labelY] = getSmoothStepPath({
            sourceX,
            sourceY,
            targetX,
            targetY,
            sourcePosition,
            targetPosition,
            borderRadius: 0
        });

        return (
            <>
                <BaseEdge
                    path={edgePath}
                    markerEnd={markerEnd}
                    style={style}
                />
                <EdgeLabelRenderer>
                    <div
                        style={{
                            position: 'absolute',
                            transform: `translate(-50%, -50%) translate(${labelX}px,${labelY}px)`,
                            pointerEvents: 'all',
                        }}
                        className="nodrag nopan"
                    >
                        <button
                            onClick={() => onEdgeDelete(id)}
                            style={{
                                background: '#ff4d4f',
                                color: 'white',
                                border: 'none',
                                borderRadius: '50%',
                                width: '20px',
                                height: '20px',
                                fontSize: '12px',
                                cursor: 'pointer',
                                display: 'flex',
                                justifyContent: 'center',
                                alignItems: 'center',
                                boxShadow: '0 2px 4px rgba(0,0,0,0.2)'
                            }}
                            title="Eliminar conexión"
                        >
                            ×
                        </button>
                    </div>
                </EdgeLabelRenderer>
            </>
        );
    };

    const onEdgeDelete = useCallback(async (edgeId) => {
        try {
            const response = await fetch(`../../conexiones/delete/${edgeId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                throw new Error('Error al eliminar la conexión');
            }

            setEdges((eds) => eds.filter((edge) => edge.id !== edgeId));
        } catch (error) {
            console.error('Error al eliminar la edge:', error);
        }
    }, []);

    const edgeTypes = useMemo(() => ({
        deletable: (props) => <CustomEdge {...props} onEdgeDelete={onEdgeDelete} />,
    }), [onEdgeDelete]);

    const edgesWithDeleteButton = edges.map(edge => ({
        ...edge,
        type: 'deletable'
    }));

    const saveNodeToDatabase = async (nodeData) => {
        try {
            const response = await axios.post(`../../nodos/store/${organigramaId}`, nodeData);
            return response.data.id;
        } catch (error) {
            console.error('Error al guardar el nodo:', error);
            return null;
        }
    };

    const deleteNodeToDatabase = async (nodeData) =>  {
        try {
            await axios.get(`../../nodos/delete/${nodeData.id}`);
            return true;
        } catch (error) {
            console.error('Error al guardar el nodo:', error);
            return null;
        }
    }

    const deleteGroupMemberToDatabase = async (integrante) =>  {
        try {
            await axios.get(`../../integrantes/delete/${integrante}`);
            return true;
        } catch (error) {
            console.error('Error al guardar el nodo:', error);
            return null;
        }
    }

    const deleteResponsabilityToDatabase = async (responsable) =>  {
        try {
            await axios.get(`../../responsables/delete/${responsable}`);
            return true;
        } catch (error) {
            console.error('Error al guardar el nodo:', error);
            return null;
        }
    }

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleSaveNode = async () => {
        if (!formData.title) {
            alert('Por favor, completa al menos el título y subtítulo.');
            return;
        }

        try {
            if (currentNode) {
                await updateNodeInDatabase(formData);
                setNodes(nds => nds.map(n => {
                    if (n.id === currentNode.id) {
                        return {
                            ...n,
                            data: {
                                ...n.data,
                                title: formData.title,
                                subtitle: formData.subtitle,
                                type: formData.type,
                                color: formData.color,
                                icon: formData.icon,
                            }
                        };
                    }
                    return n;
                }));
            } else {
                const newNodeId = await saveNodeToDatabase(formData);
                addNode({ ...formData, id: newNodeId });
            }

            setIsModalOpen(false);
            setCurrentNode(null);
            setIsEditing(false);
        } catch (error) {
            toast.error(error.response.data.message, {
                ariaLabel: "something"
            })
        }
    };

    const addNode = useCallback((data) => {
        const newNode = {
            id: data.id.toString(),
            type: 'orgNode',
            position: {
                x: 0,
                y: 0,
            },
            data: {
                id: data.id,
                title: data.title,
                subtitle: data.subtitle,
                type: data.type,
                color: data.color,
                icon: data.icon,
            },
        };

        setNodes((currentNodes) => [...currentNodes, newNode]);
    }, [setNodes]);

    const updateNodeInDatabase = async (nodeData) => {
        try {
            const response = await axios.post(`../../nodos/update/${nodeData.id}`, nodeData);
            return response.data;
        } catch (error) {
            console.error('Error al actualizar el nodo:', error);
            throw error;
        }
    };

    const openCreateModal = () => {
        setCurrentNode(null);
        setFormData({
            id: '',
            title: '',
            subtitle: '',
            type: 'D',
            color: '#3b82f6',
            icon: '',
        });
        setIsModalOpen(true);
    };

    const handleDeleteNode = async () => {
        if (currentNode) {
            try {
                if (currentNode) {
                    await deleteNodeToDatabase(formData);
                    setNodes(nodes.filter((node) => node.id !== currentNode.id));
                    setEdges(
                        edges.filter(
                        (edge) => edge.source !== currentNode.id && edge.target !== currentNode.id
                        )
                    );
                }

                setIsModalOpen(false);
                setCurrentNode(null);
                setIsEditing(false);
            } catch (error) {
                alert('Error al eliminar el nodo');
            }
        }
    };

    const handleDeleteGroupMember = async (integranteId) => {
        try {
            await deleteGroupMemberToDatabase(integranteId);
            setIntegrantes(integrantes =>
                integrantes.filter(integrante => integrante.id !== integranteId)
            );
        } catch (error) {
            alert('Error al eliminar el integrante');
        }
    };

    const handleDeleteResponsability = async (responsabilidadId) => {
        try {
            await deleteResponsabilityToDatabase(responsabilidadId);
            setResponsabilidades(responsabilidades =>
                responsabilidades.filter(responsabilidad => responsabilidad.id !== responsabilidadId)
            );
        } catch (error) {
            alert('Error al eliminar el responsabilidad');
        }
    };

    const handleEditGroupMembers = (integrante) => {
        setIsEditingGroupMember(true);
        setCurrentIntegranteId(integrante.id);

        const useFicha = !!integrante.ficha_id;

        setFormDataGroupMembers({
            nombre: integrante.nombre || '',
            puesto: integrante.puesto || '',
            ficha_id: useFicha ? integrante.ficha_id : null,
            coordinador: integrante.coordinador === 'S',
            orden: integrante.orden || 0,
            useFicha: useFicha
        });

        setSelectedTabIndex(0);
    };

    const resetForm = () => {
        setFormDataGroupMembers({
            nombre: '',
            puesto: '',
            ficha_id: null,
            coordinador: false,
            orden: 0,
            useFicha: false
        });
        setIsEditingGroupMember(false);
        setCurrentIntegranteId(null);
        setSelectKey(prev => prev + 1);
    };

    const handleEditResponsabilities = (responsabilidad) => {
        setIsEditingResponsability(true);
        setCurrentResponsabilityId(responsabilidad.id);

        setFormDataResponsabilities({
            descripcion: responsabilidad.descripcion || '',
            orden: responsabilidad.orden || 0,
        });

        setSelectedTabIndexResponsabilities(0);
    };

    const resetFormResponsabilities = () => {
        setFormDataResponsabilities({
            descripcion: '',
            orden: 0,
        });
        setIsEditingResponsability(false);
        setCurrentResponsabilityId(null);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        const payload = {
            nodo_id: currentNode.id,
            puesto: formDataGroupMembers.puesto,
            coordinador: formDataGroupMembers.coordinador ? 'S' : 'N',
            orden: formDataGroupMembers.orden,
            ...(formDataGroupMembers.useFicha
                ? { ficha_id: formDataGroupMembers.ficha_id }
                : { nombre: formDataGroupMembers.nombre}),
        };

        let url = `../../integrantes/store/${currentNode.id}`;
        let method = 'POST';

        if (isEditingGroupMember && currentIntegranteId) {
            url = `../../integrantes/update/${currentIntegranteId}`;
            method = 'POST';
        }

        const res = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
        });

        const responseData = await res.json();

        const sortByOrder = (a, b) => a.orden - b.orden;
        if (isEditingGroupMember) {
            setIntegrantes(integrantes.map(integrante =>
                integrante.id === currentIntegranteId ? responseData.integrante : integrante
            ).sort(sortByOrder));
        } else {
            setIntegrantes([...integrantes, responseData.integrante].sort(sortByOrder));
        }

        resetForm();
    };

    const handleSubmitResponsability = async (e) => {
        e.preventDefault();
        const payload = {
            nodo_id: currentNode.id,
            descripcion: formDataResponsabilities.descripcion,
            orden: formDataResponsabilities.orden
        };

        let url = `../../responsabilidades/store/${currentNode.id}`;

        if (setIsEditingResponsability && currentResponsabilityId) {
            url = `../../responsabilidades/update/${currentResponsabilityId}`;
        }

        const res = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
            body: JSON.stringify(payload)
        });

        const responseData = await res.json();

        const sortByOrder = (a, b) => a.orden - b.orden;
        if (isEditingResponsability) {
            setResponsabilidades(responsabilidades.map(responsabilidad =>
                responsabilidad.id === currentResponsabilityId ? responseData.responsabilidad : responsabilidad
            ).sort(sortByOrder));
        } else {
            setResponsabilidades([...responsabilidades, responseData.responsabilidad].sort(sortByOrder));
        }

        resetFormResponsabilities();

    };

    const toggleMode = () => {
        setFormDataGroupMembers(prev => ({
        ...prev,
        useFicha: !prev.useFicha,
        nombre: '', // Reset campos al cambiar modo
        puesto: '',
        ficha_id: ''
        }));
    };

    const toggleMode2 = () => {
        setFormDataGroupMembers(prev => ({
            ...prev,
            coordinador: !prev.coordinador,
        }));
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormDataGroupMembers(prev => ({ ...prev, [name]: value }));
    };

    const handleChangeResponsability = (e) => {
        const { name, value } = e.target;
        setFormDataResponsabilities(prev => ({ ...prev, [name]: value }));
    };

    const updatePositionNodeInDatabase = async (node) => {
        try {
            const response = await axios.post(`../../nodos/update/position/${node.id}`, node.position);
            return response.data;
        } catch (error) {
            console.error('Error al actualizar el nodo:', error);
            throw error;
        }
    }

    const onNodeDragStop = useCallback (async (event, node) => {
        await updatePositionNodeInDatabase(node);

        setNodes(nds => nds.map(nd => {
            if (nd.id === node.id) {
                return { ...nd, position: node.position };
            }
            return nd;
        }));
    });

    return (
        <div class="w-full bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <ToastContainer ariaLabel="Notifications ⌘ + F" />



            <div class="flex items-start justify-between mb-2">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                        Editar Organigrama
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Formulario para editar organigramas
                    </p>
                </div>
                <button
                    onClick={openCreateModal}
                    className=" z-10 top-4 left-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                    <LucideIcons.CirclePlus />
                </button>
            </div>

            <div style={{ height: '65vh', width: '100%' }}>
                <ReactFlow
                    nodes={nodes}
                    edges={edgesWithDeleteButton}
                    onNodesChange={onNodesChange}
                    onEdgesChange={onEdgesChange}
                    onConnect={onConnect}
                    nodeTypes={nodeTypes}
                    fitView
                    fitViewOptions={{ padding: 0.5 }}
                    edgeTypes={edgeTypes}
                    connectionLineType="straight"
                    onNodeDragStop={onNodeDragStop}
                    snapGrid={snapGrid}
                    snapToGrid={true}
                >
                    <Controls />
                    <MiniMap />
                    <Background variant="dots" gap={12} size={1} />
                </ReactFlow>
            </div>

            <Modal isOpen={isModalOpen} onClose={() => setIsModalOpen(false)}>
                <h2 className="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4"> {currentNode ? 'Editar Miembro' : 'Añadir Nuevo Miembro'} </h2>
                <div className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Título</label>
                        <input
                            type="text"
                            name="title"
                            value={formData.title}
                            onChange={handleInputChange}
                            className="mt-1 block w-full px-3 py-2 border border-gray-300 text-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700">Subtítulo</label>
                        <input
                            type="text"
                            name="subtitle"
                            value={formData.subtitle}
                            onChange={handleInputChange}
                            className="mt-1 block w-full px-3 py-2 border border-gray-300 text-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700">Tipo</label>
                        <div className="mt-1 flex items-center space-x-4">
                            <label className="inline-flex items-center">
                                <input
                                    type="radio"
                                    name="type"
                                    value="D"
                                    checked={formData.type == 'D'}
                                    onChange={handleInputChange}
                                    className="h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                                />
                                <span className="ml-2">Detallado</span>
                            </label>
                            <label className="inline-flex items-center">
                                <input
                                    type="radio"
                                    name="type"
                                    value="R"
                                    checked={formData.type == 'R'}
                                    onChange={handleInputChange}
                                    className="h-4 w-4 text-indigo-600 focus:ring-indigo-500"
                                />
                                <span className="ml-2">Resumido</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700">Color</label>
                        <ColorPicker
                            name="color"
                            value={formData.color}
                            onChange={handleInputChange}
                            className="mt-1"
                        />
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700">Ícono</label>
                        <select
                            name="icon"
                            value={formData.icon}
                            onChange={handleInputChange}
                            className="mt-1 block w-full px-3 py-2 border border-gray-300 text-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        >
                            <option value="">Seleccionar ícono</option>
                            <option value="user">Usuario</option>
                            <option value="manager">Gerente</option>
                            <option value="team">Equipo</option>
                            <option value="department">Departamento</option>
                        </select>
                    </div>
                </div>

                <div className="mt-6 flex justify-between space-x-4">
                    {currentNode && (
                        <div>
                        <button
                            onClick={handleDeleteNode}  // Asegúrate de tener esta función definida
                            className="bg-rose-500 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Eliminar
                        </button>
                        </div>
                    )}

                    {!currentNode && <div className="flex-1"></div>}
                    <div className='flex items-center space-x-4'>
                        <button
                            onClick={() => setIsModalOpen(false)}
                            className="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded"
                        >
                            Cancelar
                        </button>
                        <button
                            onClick={handleSaveNode}
                            className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        >
                            {currentNode ? 'Actualizar' : 'Guardar'}
                        </button>
                    </div>
                </div>
            </Modal>

            <Modal isOpen={isModalOpenGroupMembers} onClose={() => {
                    setIsModalOpenGroupMembers(false);
                    setIsEditingGroupMember(false);
                }}>
                <Tab.Group selectedIndex={selectedTabIndex} onChange={setSelectedTabIndex}>
                    <Tab.List className="flex border-b">
                        <Tab className={({ selected }) => `px-4 py-2 ${selected ? 'border-b-2 border-blue-500' : ''}`}>
                        Agregar Integrante
                        </Tab>
                        <Tab className={({ selected }) => `px-4 py-2 ${selected ? 'border-b-2 border-blue-500' : ''}`}>
                        Listado ({integrantes.length})
                        </Tab>
                    </Tab.List>
                    <Tab.Panels className="mt-4">
                        <Tab.Panel>
                            <form onSubmit={handleSubmit}>
                                <div className='flex items-center mb-4'>
                                    <div class="flex items-center gap-x-3">
                                        <label for="hs-xs-switch" class="relative inline-block w-9 h-5 cursor-pointer">
                                            <input
                                                checked={formDataGroupMembers.useFicha}
                                                onChange={toggleMode}
                                                type="checkbox"
                                                id="hs-xs-switch"
                                                class="peer sr-only"
                                            />
                                            <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                                            <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-4 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                                        </label>
                                        <label for="hs-xs-switch" class="text-sm text-gray-500 dark:text-neutral-400">Usar Ficha?</label>
                                    </div>

                                    <div class="flex items-center gap-x-3 ml-4">
                                        <label for="coordinador" class="relative inline-block w-9 h-5 cursor-pointer">
                                            <input
                                                checked={formDataGroupMembers.coordinador}
                                                onChange={toggleMode2}
                                                type="checkbox"
                                                id="coordinador"
                                                class="peer sr-only"
                                            />
                                            <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                                            <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-4 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                                        </label>
                                        <label for="coordinador" class="text-sm text-gray-500 dark:text-neutral-400">Es coordinador?</label>
                                    </div>
                                </div>

                                {formDataGroupMembers.useFicha ? (
                                    <div className="mb-4">
                                        <label className="block mb-2">Ficha</label>
                                        <Select
                                            key={`ficha-select-${selectKey}`}
                                            name="ficha_id"
                                            value={fichaOptions.find(option => option.value.toString() === formDataGroupMembers.ficha_id.toString())}
                                            onChange={handleFichaChange}
                                            options={fichaOptions}
                                            placeholder="Buscar ficha..."
                                            isClearable
                                            className="basic-multi-select"
                                            classNamePrefix="select"
                                            required
                                            styles={{
                                                control: (provided) => ({
                                                    ...provided,
                                                    minHeight: '42px',
                                                    border: '1px solid #d1d5db',
                                                    borderRadius: '0.375rem',
                                                }),
                                            }}
                                        />
                                    </div>
                                ) : (
                                <>
                                    <div className="mb-4">
                                    <label className="block mb-2">Nombre</label>
                                    <input
                                        type="text"
                                        name="nombre"
                                        value={formDataGroupMembers.nombre}
                                        onChange={handleChange}
                                        className="mt-1 block w-full px-3 py-2 border border-gray-300 text-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        required
                                    />
                                    </div>

                                </>
                                )}

                                <div className="mb-4">
                                    <label className="block mb-2">Puesto</label>
                                    <input
                                        type="text"
                                        name="puesto"
                                        value={formDataGroupMembers.puesto}
                                        onChange={handleChange}
                                        className="mt-1 block w-full px-3 py-2 border border-gray-300 text-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        required
                                    />
                                </div>

                                <div className="mb-4">
                                    <label className="block mb-2">Orden</label>
                                    <input
                                        type="number"
                                        name="orden"
                                        value={formDataGroupMembers.orden}
                                        onChange={handleChange}
                                        className="mt-1 block w-full px-3 py-2 border border-gray-300 text-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        required
                                    />
                                </div>

                                {/* Botones */}
                                <div className="flex justify-end space-x-2 mt-4">
                                    <button
                                        type="button"
                                        onClick={() => setIsModalOpenGroupMembers(false)}
                                        className="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded"
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        onClick={handleSubmit}
                                        className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        disabled={!formDataGroupMembers.nombre && !formDataGroupMembers.ficha_id} // Validación
                                    >
                                        {isEditingGroupMember ? 'Actualizar' : 'Agregar'}
                                    </button>
                                </div>
                            </form>
                        </Tab.Panel>

                        <Tab.Panel>
                            <div className="max-h-96 overflow-y-auto w-full px-2 [&::-webkit-scrollbar]:w-2
                                    [&::-webkit-scrollbar-track]:bg-gray-100
                                    [&::-webkit-scrollbar-thumb]:bg-gray-300
                                    dark:[&::-webkit-scrollbar-track]:bg-neutral-700
                                    dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                                <table className='w-full'>
                                    <thead>
                                        <tr>
                                            <th className='w-1/2 text-left'>Nombre</th>
                                            <th className='w-1/3 text-left'>Puesto</th>
                                            <th className='w-1/3 text-left'>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        {integrantes.map(integrante => (
                                        <tr key={integrante.id}>
                                            <td className={`${integrante.coordinador === 'S' ? 'font-bold' : ''}`}>{integrante.nombre || integrante.ficha_id?.nombre}</td>
                                            <td className={`${integrante.coordinador === 'S' ? 'font-bold' : ''}`}>{integrante.puesto || integrante.ficha_id?.puesto}</td>
                                            <td className='mx-2'>
                                                <button
                                                onClick={() => handleEditGroupMembers(integrante)}
                                                className="text-blue-500 hover:text-blue-700 p-2 bg-gray-100 hover:bg-gray-50 text-xs font-bold rounded"
                                                >
                                                <LucideIcons.Pencil className='w-4' />
                                                </button>

                                                <button
                                                onClick={() => handleDeleteGroupMember(integrante.id)}
                                                className="text-red-500 hover:text-red-700 p-2 bg-gray-100 hover:bg-gray-50 text-xs font-bold rounded ml-2"
                                                >
                                                 <LucideIcons.Trash2 className='w-4' />
                                                </button>
                                            </td>
                                        </tr>
                                        ))}
                                    </tbody>
                                </table>

                            </div>
                        </Tab.Panel>
                    </Tab.Panels>
                </Tab.Group>
            </Modal>

            <Modal isOpen={isModalOpenResponsabilities} onClose={() => {
                setIsModalOpenResponsabilities(false)
                setIsEditingResponsabilit(false)
            }}>
                <Tab.Group selectedIndex={selectedTabIndexResponsabilities} onChange={setSelectedTabIndexResponsabilities}>
                    <Tab.List className="flex border-b">
                        <Tab className={({ selected }) => `px-4 py-2 ${selected ? 'border-b-2 border-blue-500' : ''}`}>
                        Agregar Responsabilidad
                        </Tab>
                        <Tab className={({ selected }) => `px-4 py-2 ${selected ? 'border-b-2 border-blue-500' : ''}`}>
                        Listado ({responsabilidades.length})
                        </Tab>
                    </Tab.List>
                    <Tab.Panels className="mt-4">
                        <Tab.Panel>
                            <form onSubmit={handleSubmitResponsability}>
                                <div className="mb-4">
                                    <label className="block mb-2">Descripcion</label>
                                    <input
                                        type="text"
                                        name="descripcion"
                                        value={formDataResponsabilities.descripcion}
                                        onChange={handleChangeResponsability}
                                        className="mt-1 block w-full px-3 py-2 border border-gray-300 text-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        required
                                    />
                                    </div>
                                    <div className="mb-4">
                                    <label className="block mb-2">Orden</label>
                                    <input
                                        type="number"
                                        name="orden"
                                        value={formDataResponsabilities.orden}
                                        onChange={handleChangeResponsability}
                                        className="mt-1 block w-full px-3 py-2 border border-gray-300 text-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                        required
                                    />
                                </div>


                                {/* Botones */}
                                <div className="flex justify-end space-x-2 mt-4">
                                    <button
                                        type="button"
                                        onClick={() => setIsModalOpenResponsabilities(false)}
                                        className="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded"
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        onClick={handleSubmitResponsability}
                                        className="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded"
                                        disabled={!formDataResponsabilities.descripcion}
                                    >
                                        {isEditingResponsability ? 'Actualizar' : 'Agregar'}
                                    </button>
                                </div>
                            </form>
                        </Tab.Panel>

                        <Tab.Panel>
                        <h3 className="font-medium mb-2">Responsabilidades</h3>
                            <ul className="max-h-96 overflow-y-auto">
                                {responsabilidades.map(responsabilidad => (
                                <li key={responsabilidad.id} className="py-1 flex justify-between">
                                    <span>
                                    {responsabilidad.descripcion}
                                    </span>

                                    <div className='flex items-center gap-x-2'>
                                    <button
                                    onClick={() => handleEditResponsabilities(responsabilidad)}
                                    className="text-blue-500 hover:text-blue-700 p-2 bg-gray-100 hover:bg-gray-50 text-xs font-bold rounded"
                                    >
                                    <LucideIcons.Pencil className='w-4' />
                                    </button>
                                    <button
                                    onClick={() => handleDeleteResponsability(responsabilidad.id)}
                                    className="text-red-500 hover:text-red-700 p-2 bg-gray-100 hover:bg-gray-50 text-xs font-bold rounded ml-2"
                                    >
                                    <LucideIcons.Trash2 className='w-4' />
                                    </button>
                                    </div>
                                </li>
                                ))}
                            </ul>
                        </Tab.Panel>
                    </Tab.Panels>
                </Tab.Group>
            </Modal>
        </div>
    );
}

export default OrgChart;
