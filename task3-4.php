<?php
/**
 * @author Siarhei Sharykhin
 */


/**
 * Interface NavigatorInterface
 */
Interface NavigatorInterface
{
    public function setMap($map);
    public function getMap();
}

/**
 * Class ScouterService
 */
class ScouterService implements NavigatorInterface
{
    /** @var array $map - map for current scouter */
    private $map = array();
    /** @var array $visitedNodes - visited nodes in current path */
    private $visitedNodes = array();
    /** @var null | array $shortestPath - the shortest path */
    private $shortestPath = null;
    /** @var array $visitedPaths - all paths in the map */
    private $visitedPaths = array();
    /** @var array $availablePaths - available paths of all */
    private $availablePaths = array();

    /**
     * Set current map
     *
     * @param array $map
     * @return $this
     * @throws Exception
     */
    public function setMap($map)
    {
        if (!is_array($map)) {
            throw new Exception('parameter has to be array');
        }
        $this->map = $map;
        return $this;
    }

    /**
     * Get current map
     *
     * @return array
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Return available paths
     *
     * @return array
     */
    public function getPaths()
    {
        return $this->availablePaths;
    }

    /**
     * Find the available paths of all paths
     *
     * @param string $to
     */
    private function setAvailablePaths($to)
    {
        $availablePaths = array();
        foreach($this->visitedPaths as $path) {
            if ($path[sizeof($path)-1] === $to ) {
                $availablePaths[] = $path;
            }
        }
        $this->availablePaths = $availablePaths;
    }

    /**
     * Return the shortest path of current router
     *
     * @return null
     *
     */
    public function getShortestPath()
    {
        return $this->shortestPath;
    }

    /**
     * Find the as available paths as the shortest of them in the router
     *
     * @param string $from
     * @param string $to
     * @return $this
     * @throws Exception
     */
    public function findPaths($from,$to)
    {
        // Check if user has setted the map, if not throw an exacption such as map is required
        if(empty($this->map)) {
            throw new Exception('You didn\'t specify map');
        }
        // Make coordinates to uppercase to avoid errors in the comparisons
        $from = strtoupper(trim($from));
        $to = strtoupper(trim($to));

        // Start searching the paths by getting first available paths
        $firstAvailableStep = $this->map[$from];
        // Add to visited our first node, such as it's forbidden to return to visited nodes
        array_push($this->visitedNodes,$from);
        // Run recursive function, which find all paths, event if they don't reach the end point
        $this->searchPath($firstAvailableStep,$to);
        //Set to property availablePaths real available paths from all of them
        $this->setAvailablePaths($to);
        // Set the shortest path of all available
        $this->shortestPath = min($this->availablePaths);
        // erase previous paths and nodes to avoid errors in next findings
        $this->visitedPaths = array();
        $this->visitedNodes = array();
        // Return instance to give an opportunity of making chains
        return $this;

    }

    /**
     * Recursive function, which finds all paths
     *
     * @param array $step
     * @param string $to
     * @return bool
     */
    private  function searchPath(array $step, $to)
     {

        foreach($step as $node) {
            // If current node hasn't been visited, add it to current path
            if (!in_array($node,$this->visitedNodes)) {
                array_push($this->visitedNodes,$node);
                // If current path has been already followed remove two last points and take next node
                if (in_array($this->visitedNodes, $this->visitedPaths)) {
                    $this->visitedNodes=array_slice($this->visitedNodes,0,-2);
                    continue;
                }
            }
            // Check if current node is end point
            if($node !== $to) {

                $nextStep = $this->map[$node];
                // Make filter to find available nodes, such as it's forbidden to return to visited nodes
                $availableNextStep = array();
                foreach($nextStep as $nextNodes) {
                    if (!in_array($nextNodes,$this->visitedNodes)) {
                        $availableNextStep[]=$nextNodes;
                    }
                }
                // If there are no available points add current path to visitedPaths, remove last node and take next node
                if (empty($availableNextStep)) {
                    $this->visitedPaths[] = $this->visitedNodes;
                    $this->visitedNodes=array_slice($this->visitedNodes,0,-1);
                    continue;
                }
                // Call recursive function and with next available nodes
                $this->searchPath($availableNextStep, $to);
                // Remove last node such as we need te return to previous node
                $this->visitedNodes=array_slice($this->visitedNodes,0,-1);

            } else {
                // Add to visitedPath successful route
                $this->visitedPaths[] = $this->visitedNodes;
                // Remove last node
                $this->visitedNodes=array_slice($this->visitedNodes,0,-1);

            }
        }

         return true;
    }

}

$map = array(
    'A' => array('B','C','F'),
    'B' => array('A','C','E'),
    'E' => array('B','F'),
    'C' => array('A','B','D','F'),
    'D' => array('C','F'),
    'F' => array('A','C','D','E','G'),
    'G' => array('F')
);
// Create a scouter
$scouter = new ScouterService();
//Set map and find pathes from A to G
$scouter->setMap($map)->findPaths('A','G');
echo "<h3>All routers from A to G:</h3> <br/>";
foreach($scouter->getPaths() as $path) {
    echo implode(' -> ',$path) . "<br/>";
}
echo "<h3>The shortest path from A to G:  </h3>" . implode(' -> ',$scouter->getShortestPath());

echo "<hr/>";
//Find paths from C to F
$scouter->findPaths('c','f');
echo "All routers from C to F: <br/>";
foreach($scouter->getPaths() as $path) {
    echo implode(' -> ',$path) . "<br/>";
}
echo "The shortest path from C to F:  " . implode(' -> ',$scouter->getShortestPath());

echo "<hr/>";
//Find paths from D to F
$scouter->findPaths('D','F');
echo "All routers from D to F: <br/>";
foreach($scouter->getPaths() as $path) {
    echo implode(' -> ',$path) . "<br/>";
}
echo "The shortest path from D to F: " . implode(' -> ',$scouter->getShortestPath());

echo "<hr/>";
//Find paths from G to A
$scouter->findPaths('G','A');
echo "All routers from G to A: <br/>";
foreach($scouter->getPaths() as $path) {
    echo implode(' -> ',$path) . "<br/>";
}
echo "The shortest path from G to A: " . implode(' -> ',$scouter->getShortestPath());

