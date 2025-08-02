import dagre from 'dagre';

const dagreGraph = new dagre.graphlib.Graph();
dagreGraph.setDefaultEdgeLabel(() => ({}));

// Aumenté las dimensiones para acomodar mejor tus nodos
const NODE_WIDTH = 250;
const NODE_HEIGHT = 100;
const RANK_SEP = 220; // Separación vertical entre niveles
const NODE_SEP = 100; // Separación horizontal entre nodos

export const dagreLayout = (nodes, edges, direction = 'TB') => {
  dagreGraph.setGraph({
    rankdir: direction,
    ranksep: RANK_SEP,
    nodesep: NODE_SEP
  });

  nodes.forEach((node) => {
    dagreGraph.setNode(node.id, {
      width: NODE_WIDTH,
      height: NODE_HEIGHT
    });
  });

  edges.forEach((edge) => {
    dagreGraph.setEdge(edge.source, edge.target);
  });

  dagre.layout(dagreGraph);

  nodes.forEach((node) => {
    const nodeWithPosition = dagreGraph.node(node.id);
    node.position = {
      x: nodeWithPosition.x - NODE_WIDTH / 2,
      y: nodeWithPosition.y - NODE_HEIGHT / 2,
    };
    return node;
  });

  return { nodes, edges };
};
