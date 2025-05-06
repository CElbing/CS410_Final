public class generateAdvice {
    
    public String createAdvice(double[] goalPercentages, double[] wants, double[] needs, double[] savings){
        String output = "";
        //the index of goal percentages is as follows: 0 = wants, 1 = needs, 2 = savings
        //it will be the same for the statistics array
        double[] stats = generateStats.createStats(wants, needs, savings, goalPercentages);
        
        if(stats[0] > (goalPercentages[0] + 5)){
            output = "You are spending too much on wants. You should cut back on your spending on wants.";
        }
        else if(stats[1] > (goalPercentages[1] + 5)){
            output = "You are spending too much on needs. You should cut back on your spending on needs.";
        }
        else if(stats[2] > (goalPercentages[2] + 5)){
            output = "You are spending too much on savings. You should cut back on your spending on saving.";
        }
        else if(stats[0] > (goalPercentages[0] + 5) && stats[1] > (goalPercentages[1] + 5)){
            output = "You are spending too much on wants and needs. You should cut back on your spending in these areas.";
        }
        else if(stats[0] > (goalPercentages[0] + 5) && stats[2] > (goalPercentages[2] + 5)){
            output = "You are spending too much on wants and savings. You should cut back on your spending in these areas.";
        }
        else if(stats[1] > (goalPercentages[1] + 5) && stats[2] > (goalPercentages[2] + 5)){
            output = "You are spending too much on needs and savings. You should cut back on your spending in these areas.";
        }
        else{
            output = "You are spending within your goals. Keep up the good work!";
        }
    return output;
    }
}