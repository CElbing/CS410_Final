public class generateStats{
    
    public static double[] createStats(double[] wants, double[] needs, double[] savings, double[] goalPercentages){
        double wantsTotal = 0;
        double needsTotal = 0;
        double savingsTotal = 0;
        double total = 0;
        double[] stats = new double[3];
        for(int i = 0; i < wants.length; i++){
            wantsTotal += wants[i];
        }
        for(int i = 0; i < needs.length; i++){
            needsTotal += needs[i];
        }
        for(int i = 0; i < savings.length; i++){
            savingsTotal += savings[i];
        }
        total = wantsTotal + needsTotal + savingsTotal;
        //the index of goal percentages is as follows: 0 = wants, 1 = needs, 2 = savings
        //it will be the same for the statistics array
        stats[0] = Math.round((wantsTotal / total) * 100);
        stats[1] = Math.round((needsTotal / total) * 100);
        stats[2] = Math.round((savingsTotal / total) * 100);
        return stats;
    }
    
}