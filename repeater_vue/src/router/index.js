import { createRouter, createWebHashHistory } from 'vue-router'

import SignIn     from '../components/authentication/SignIn.vue'
import SignUp     from '../components/newUser/SignUp.vue'
import ForgotPass from '../components/authentication/ForgotPass.vue'
import Home       from '../components/authentication/Home.vue'
import PorchSite  from '../components/PorchSite.vue'
import MainScreen from '../components/MainScreen.vue'
import NewCourse  from '../components/course/NewCourse'
import ResetPassForm from '../components/authentication/ResetPassForm'
import InnerCourse from '../components/course/InnerCourse'
import NewLesson from '../components/lesson/NewLesson'
import InnerLesson from '../components/lesson/InnerLesson'
import SingleImport from '../components/cards/SingleImport'
import MassImport from '../components/cards/MassImport'
import MainOptions from '../components/settings/MainOptions'
import LearningNew from '../components/presentations/LearningNew'
import RepeatPhase from '../components/presentations/RepeatPhase'
import EditCard from '../components/cards/EditCard'
import AccountActivation from '../components/newUser/AccountActivation'
import EditLesson from '../components/lesson/EditLesson'
import TenminRepeat from '../components/presentations/TenminRepeat'


const routes = [
  { path: '/signin', component: SignIn },
  { path: '/signup', component: SignUp },
  { path: '/resetform/:token', component: ResetPassForm },
  { path: '/forgot/', component: ForgotPass },  
  { path: '/',       component: Home },
  { path: '/porch',  component: PorchSite },
  { path: '/mainscreen', component: MainScreen },
  { path: '/newcourse' , component: NewCourse },
  { path: '/innercourse/:courseId', component: InnerCourse },
  { path: '/newlesson/:courseId', component: NewLesson },
  { path: '/innerlesson/:lessonId', component: InnerLesson },
  { path: '/singleimport/:lessonId', component: SingleImport },
  { path: '/massimport/:lessonId', component: MassImport },
  { path: '/settings', component: MainOptions },
  { path: '/learning/:courseId', component: LearningNew },
  { path: '/repeating/:courseId', component: RepeatPhase },
  { path: '/editcard/:cardId', component: EditCard },
  { path: '/accountactivation/:token', component: AccountActivation },
  { path: '/editlesson/:lessonId', component: EditLesson },
  { path: '/tenminrepeat/:courseId', component: TenminRepeat }
  


]

const router = createRouter({
  history: createWebHashHistory('/'),
  routes
});

export default router
